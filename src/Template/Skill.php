<?php
/**
 * Class Skill
 *
 * @filesource   Skill.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\GW1DB\Data\GWDataMisc;
use chillerlan\GW1DB\Data\GWSkillDB;

class Skill extends TemplateAbstract{

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	protected $rank;

	/**
	 * @var string
	 */
	protected $primaryRank;

	/**
	 * @var string
	 */
	protected $skillname;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * Skill constructor.
	 *
	 * @param int|null    $skillID
	 * @param string|null $defaultLang
	 */
	public function __construct(int $skillID, string $defaultLang = null){
		$this->id = $skillID;
		$this->data = GWSkillDB::id2skill[$this->id] ?? GWSkillDB::id2skill[0];

		if($defaultLang = null){
			$this->defaultLang = $defaultLang;
		}

		$this->lang = $this->defaultLang;
	}

	/**
	 * @param string      $rank
	 * @param string|null $primaryRank
	 *
	 * @return \chillerlan\GW1DB\Template\Skill
	 */
	public function setAttributeRank(string $rank, string $primaryRank = null):Skill{
		$this->rank        = $rank;
		$this->primaryRank = $primaryRank;

		return $this;
	}

	/**
	 * @param bool|null $image
	 * @param bool|null $image_huge
	 * @param bool|null $inBuild
	 *
	 * @return string
	 */
	public function toHTML(bool $image = null, bool $image_huge = null, bool $inBuild = null):string{
		$pvp             = $this->isPvP && $this->data['split'];
		$mode            = $pvp ? 'pvp' : 'pve';
		$prof_skill      = GWDataMisc::professions[$this->data['profession']];
		$prof_pri        = GWDataMisc::professions[$this->pri];
		$pcn             = strtolower($prof_skill['name']['en']);
		$this->skillname = $this->sanitize(stripslashes($this->data[$mode]['name'][$this->lang]));

		$a = [
			$this->data['attribute'] => $this->rank ?? 0,
			$prof_skill['pri']       => $this->primaryRank > 0 ? $this->primaryRank : null,
		];

		$this->setAttributes($a);

		$this->cssClass = [
			'gwbb-skill',
			$this->data['elite'] ? 'elite' : null,
			$this->id === 0 ? 'noskill' : null,
			in_array($this->data[$mode]['type'], $prof_pri['effect'], true) ? 'effect' : null,
		];

		if(!$inBuild){
			$this->dataset = [
				'lang' => $this->lang !== $this->defaultLang ? $this->lang : null,
				'attr' => $this->getAttributeString(),
				'pvp'  => $pvp ? (int)$pvp : null,
			];
		}

		$this->dataset['id'] = $this->id;

		if($image ?? true){ // default to image
			return $this->image($pcn, $image_huge ?? false);
		}

		return $this->link($pcn);
	}

	/**
	 * @param string $pcn
	 * @param bool   $huge
	 *
	 * @return string
	 */
	protected function image(string $pcn, bool $huge):string{
		$this->cssClass[] = $pcn;

		$src = '{IMG_SKILL_64}';

		// huge if true
		if($huge === true){ // @todo: check if available (or upscale the no-profession-skill images)
			$this->cssClass[] = 'huge';

			$src = '{IMG_SKILL_256}';
		}

		return '<img src="'.$src.'/'.$this->id.'.png" alt="'.$this->skillname.'" class="'.$this->getCssClass().'" '.$this->getDataset().'/>';
	}

	/**
	 * @param string $pcn
	 *
	 * @return string
	 */
	protected function link(string $pcn):string{
		$lvl = $this->normalizeAttributeLevel($this->rank ?? '');

		$attr_lvl  = $lvl['total'] > 0 && $this->data['attribute'] !== -1 ? $lvl['total_str'].' ' : '';
		$attr_name = GWDataMisc::attributes[$this->data['attribute']]['name'][$this->lang];

		return '<span class="gwbb-link '.$pcn.'">[<a class="'.$this->getCssClass().'" '.$this->getDataset().'>'.$this->skillname.'</a> <span class="attr">'.$attr_lvl.$attr_name.'</span>]</span>';
	}

}
