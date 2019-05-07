<?php
/**
 * Class Build
 *
 * @filesource   Build.php
 * @created      29.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\GW1DB\Data\{GWDataMisc, GWSkillDB};

class Build extends BuildAbstract{

	/**
	 * @var array
	 */
	protected $skills = [];
	protected $equipment;
	protected $weaponsets = [0 => null, 1 => null, 2 => null];

	/**
	 * @param bool|null $inPwnd
	 *
	 * @return string
	 */
	public function toHTML(bool $inPwnd = null):string{
		$extraAttributeSkills = [];
		$skill_html           = '';

		foreach($this->skills as $i => $id){
			$skill = new Skill($id, $this->defaultLang);

			// some special cases
			if(in_array($skill->id, GWDataMisc::SKILLS_ATTRIBUTE_EXTRA, true)){
				$extraAttributeSkills[] = $skill->id;
			}

			$skill_html .= $skill
				->setProfessions($this->pri, $this->sec)
				->toHTML(true, false, true)
			;
		}

		$code = $this->code ?? $this->encode();
		$this->dataset = [
			'pri'   => $this->pri,
			'sec'   => $this->sec,
			'attr'  => $this->getAttributeString(),
			'xattr' => !empty($extraAttributeSkills) ? implode(',', $extraAttributeSkills) : null,
			'code'  => $code,
		];

		if(!$inPwnd){
			$this->dataset = array_merge($this->dataset, [
				'lang' => $this->lang !== $this->defaultLang ? $this->lang : null,
				'pvp'  => $this->isPvP ? (int)$this->isPvP : null,
			]);
		}

		// @todo: check for invalid builds and add an extra css class (skills are more more than 2 professions etc.)
		$this->cssClass = [
			'gwbb-build',
			strtolower(GWDataMisc::professions[$this->pri]['name']['en']),
		];

		$trimchars = ' .,;:-_!"\''; // @todo

		$html = '<div class="'.$this->getCssClass().'">';

		if(!empty(trim($this->name, $trimchars))){
			$html .= '<div class="info">'.'<span class="name">'.$this->sanitize($this->name).'</span>'.'</div>';
		}

		/** @noinspection HtmlUnknownTarget */
		$html .= '<div class="skillbar" '.$this->getDataset().'><div class="professions">'.
		         '<img src="{IMG_PROF_64}/'.$this->pri.'.png" class="pri" alt="'.GWDataMisc::professions[$this->pri]['name'][$this->lang].'">'.
		         '<img src="{IMG_PROF_32}/'.$this->sec.'.png" class="sec" alt="'.GWDataMisc::professions[$this->sec]['name'][$this->lang].'">'.
		         '</div>'.$skill_html;

		if(!$inPwnd){
			$html .= '<div class="buttons">'.
			         '<div class="gwbb-icon save"></div>'.
			         '<div class="gwbb-icon pwnd"></div>'.
			         '<div class="gwbb-icon equip"></div>'.
			         '</div>';
		}


		$html .= '</div>';

		if(!empty(trim($this->desc, $trimchars))){
			$html .= '<div class="info">'.$this->sanitize($this->desc).'</div>';
		}

#		if($this->equipment instanceof Equipment){
#			$html .= '<div class="equipment">'.$this->equipment->toHTML().'</div>';
#		}

		$html .= '</div>'.PHP_EOL;

		return $html;
	}

	/**
	 * @param \chillerlan\GW1DB\Template\Equipment $equipment
	 *
	 * @return \chillerlan\GW1DB\Template\Build
	 */
	public function setEquipment(Equipment $equipment):Build{
		$this->equipment = $equipment;

		return $this;
	}

	/**
	 * @param int                                  $id
	 * @param \chillerlan\GW1DB\Template\Equipment $weaponset
	 *
	 * @return \chillerlan\GW1DB\Template\Build
	 */
	public function setWeaponset(int $id, Equipment $weaponset):Build{

		if($id < 0 || $id > 2){
			return $this;
		}

		$this->weaponsets[$id] = $weaponset;

		return $this;
	}

	/**
	 * @param int[] $skills
	 *
	 * @return \chillerlan\GW1DB\Template\Build
	 */
	public function setSkills(array $skills):Build{
		// @todo: guess professions for skill set
		$this->skills = array_fill(0, 8, 0);

		$i = 0;
		foreach($skills as $skill){

			if($i >= 8){
				break;
			}

			if(!is_numeric($skill)){
				continue;
			}

			$skill = intval($skill);

			$this->skills[$i] = array_key_exists($skill, GWSkillDB::id2skill) ? $skill : 0;
			$i++;
		}

		return $this;
	}

	/**
	 * @link https://wiki.guildwars.com/wiki/Skill_template_format
	 *
	 * @param string $template
	 *
	 * @return \chillerlan\GW1DB\Template\BuildInterface|null
	 */
	public function decode(string $template):?BuildInterface{
		$bin = $this->tpl_decode($template);

		if(!in_array($this->template_type, [0, 14], true)){
			// invalid skill template type
			return null;
		}

		// try to read the profession and attribute info
		// (pl, profession length code, seems to be unused yet and will always be 00)
		if(!preg_match('/^(?P<pl>[01]{2})(?P<pri>[01]{4})(?P<sec>[01]{4})(?P<attrc>[01]{4})(?P<attrl>[01]{4})/', $bin, $info)){
			// invalid skill template
			return null;
		}

		// cut 2+4+4+4+4 bits just matched
		$bin = substr($bin, 18);

		// get the attributes
		$attrl = $this->bindec_flip($info['attrl']) + 4;
		$attrc = $this->bindec_flip($info['attrc']);

		$attributes = [];

		for($i = 0; $i < $attrc; $i++){

			if(!preg_match('/^(?P<id>[01]{'.$attrl.'})(?P<val>[01]{4})/', $bin, $attr)){
				// invalid attributes
				return null;
			}

			// cut the current attribute's bits
			$bin = substr($bin, 4 + $attrl);

			$attributes[$this->bindec_flip($attr['id'])] = $this->bindec_flip($attr['val']);
		}

		// get the skillbar
		if(!preg_match('/^(?P<length>[01]{4})/', $bin, $skill)){
			// invalid skill length bits
			return null;
		}

		// cut skill length bits
		$bin = substr($bin, 4);
		$len = $this->bindec_flip($skill['length']) + 8;

		$skills = [];

		for($i = 0; $i < 8; $i++){

			if(!preg_match('/^(?P<id>[01]{'.$len.'})/', $bin, $skill)){
				// invalid skill id
				return null;
			}

			// cut current skill's bits
			$bin = substr($bin, $len);

			$skills[$i] = $this->bindec_flip($skill['id']);
		}

		$this->code = $template;

		$this
			->setSkills($skills)
			->setAttributes($attributes)
			->setProfessions($this->bindec_flip($info['pri']), $this->bindec_flip($info['sec']))
		;

		return $this;
	}

	/**
	 *
	 * @return string|null
	 */
	public function encode():?string{
		$attributes = [];

		// exclude PvE attributes
		// todo: sort attributes primary asc -> secondary asc
		foreach($this->attributes as $id => $level){

			if($id < 0){
				continue;
			}

			$attributes[$id] = $level['base'];
		}

		// start of the binary string: type (14,4), version (0,4), profession length code (0,2), each value flipped
		$bin = '0111000000';

		// add professions
		$bin .= $this->decbin_pad($this->pri, 4);
		$bin .= $this->decbin_pad($this->sec, 4);

		// add attribute count
		$bin .= $this->decbin_pad(count($attributes), 4);

		// determine attribute pad size
		$attr_pad = 5;
		if(!is_array($attributes)){
			// invalid attributes
			return null;
		}

		foreach(array_keys($attributes) as $id){
			if($id >= 32){
				$attr_pad = 6;
				break;
			}
		}

		// add attribute length code
		$bin .= $this->decbin_pad($attr_pad - 4, 4);

		// add attribute ids and corresponding values
		foreach($attributes as $id => $value){
			$bin .= $this->decbin_pad($id, $attr_pad);
			$bin .= $this->decbin_pad($value, 4);
		}

		// determine skill pad size
		$skill_pad    = 9;
		$skill_id_max = 512;
		foreach($this->skills as $id){
			if($id >= $skill_id_max){
				$skill_pad    = 1 + floor(log($id, 2));
				$skill_id_max = pow(2, $skill_pad);
			}
		}

		// add skill length code
		$bin .= $this->decbin_pad($skill_pad - 8, 4);

		// add skill ids
		foreach($this->skills as $id){
			$bin .= $this->decbin_pad($id, $skill_pad);
		}

		// add one zero value to the binary string
		$bin .= $this->decbin_pad(0, 6);

		return $this->tpl_encode($bin);
	}

}
