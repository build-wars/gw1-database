<?php
/**
 * Class SkillTemplate
 *
 * @filesource   SkillTemplate.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

class SkillTemplate extends TemplateAbstract{

	protected $type = 14;

	/**
	 * @param string $template
	 *
	 * @return array
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function decode(string $template):array {
		$bin = $this->tpl_decode($template);

		if(!in_array($this->type, [0, 14], true)){
			throw new TemplateException('invalid skill template type ('.$this->type.')');
		}


		// try to read the profession and attribute info
		// (pl, profession length code, seems to be unused yet and will always be 00)
		if(!preg_match('/^(?P<pl>[01]{2})(?P<pri>[01]{4})(?P<sec>[01]{4})(?P<attrc>[01]{4})(?P<attrl>[01]{4})/', $bin, $info)){
			throw new TemplateException('invalid skill template');
		}

		// cut 2+4+4+4+4 bits just matched
		$bin = substr($bin, 18);

		// an  array to hold the template values
		$build = [
			'type'           => $this->type,
			'code'           => $template,
			'profession_pri' => $this->bindec_flip($info['pri']),
			'profession_sec' => $this->bindec_flip($info['sec']),
			'attributes'     => [],
			'skills'         => [],
		];

		// get the attributes
		$attrl = $this->bindec_flip($info['attrl']) + 4;
		$attrc = $this->bindec_flip($info['attrc']);

		for($i = 0; $i < $attrc; $i++){

			if(!preg_match('/^(?P<id>[01]{'.$attrl.'})(?P<val>[01]{4})/', $bin, $attributes)){
				throw new TemplateException('invalid attributes');
			}

			// cut the current attribute's bits
			$bin = substr($bin, 4 + $attrl);
			// https://phpolyk.wordpress.com/2012/07/25/indirect-modification-of-overloaded-property/
			$build['attributes'][$this->bindec_flip($attributes['id'])] = $this->bindec_flip($attributes['val']);
		}

		// get the skillbar
		if(!preg_match('/^(?P<length>[01]{4})/', $bin, $skill)){
			throw new TemplateException('invalid skill length bits');
		}

		// cut skill length bits
		$bin = substr($bin, 4);
		$len = $this->bindec_flip($skill['length']) + 8;

		for($i = 0; $i < 8; $i++){

			if(!preg_match('/^(?P<id>[01]{'.$len.'})/', $bin, $skill)){
				throw new TemplateException('invalid skill id');
			}

			// cut current skill's bits
			$bin = substr($bin, $len);

			$build['skills'][$i] = $this->bindec_flip($skill['id']);
		}

		return $build;
	}

	/**
	 * @param array $build
	 *
	 * @return string
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function encode(array $build):string{
		// start of the binary string: type (14,4), version (0,4), profession length code (0,2), each value flipped
		$bin  = $this->decbin_pad($build['type'], 4);
		$bin .= '000000';

		// add professions
		$bin .= $this->decbin_pad($build['profession_pri'], 4);
		$bin .= $this->decbin_pad($build['profession_sec'], 4);

		if(!is_array($build['attributes'])){
			throw new TemplateException('invalid attributes');
		}

		// add attribute count
		$bin .= $this->decbin_pad(count($build['attributes']), 4);

		// determine attribute pad size
		$attr_pad = 5;

		foreach(array_keys($build['attributes']) as $id){

			if($id >= 32){
				$attr_pad = 6;
				break;
			}
		}

		// add attribute length code
		$bin .= $this->decbin_pad($attr_pad - 4, 4);

		// add attribute ids and corresponding values
		foreach($build['attributes'] as $id => $value){
			$bin .= $this->decbin_pad($id, $attr_pad);
			$bin .= $this->decbin_pad($value, 4);
		}

		// determine skill pad size
		$skill_pad = 9;
		$skill_id_max = 512;
		foreach($build['skills'] as $id){

			if($id >= $skill_id_max){
				$skill_pad    = floor(log($id, 2)) + 1;
				$skill_id_max = pow(2, $skill_pad);
			}
		}

		// add skill length code
		$bin .= $this->decbin_pad($skill_pad - 8, 4);

		// add skill ids
		foreach($build['skills'] as $id){
			$bin .= $this->decbin_pad($id, $skill_pad);
		}

		// add one zero value to the binary string
		$bin .= $this->decbin_pad(0, 6);

		return $this->tpl_encode($bin);
	}


}
