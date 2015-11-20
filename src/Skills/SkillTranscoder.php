<?php
/**
 * Class SkillTranscoder
 *
 * @filesource   SkillTranscoder.php
 * @created      05.11.2015
 * @package      chillerlan\GW1Database\Skills
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Skills;

use chillerlan\GW1Database\GW1DatabaseException;
use chillerlan\GW1Database\Template\Transcoder;
use chillerlan\GW1Database\Skills\Build;

/**
 *
 */
class SkillTranscoder extends Transcoder{

	/**
	 * @var \chillerlan\GW1Database\Skills\Build
	 */
	protected $template;

	/**
	 * SkillTranscoder constructor.
	 *
	 * @param \chillerlan\GW1Database\Skills\Build $template [optional]
	 */
	public function __construct(Build $template = null){
		if($template instanceof Build){
			$this->template = $template;
		}
	}

	/**
	 * @return \chillerlan\GW1Database\Skills\Build
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function get_template(){
		if(!$this->template instanceof Build){
			throw new GW1DatabaseException('Invalid skill template!');
		}

		return $this->template;
	}

	/**
	 * @param \chillerlan\GW1Database\Skills\Build $template
	 *
	 * @return $this
	 */
	public function set_template(Build $template){
		$this->template = $template;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function decode(){
		$bin = $this->template_decode($this->template->code);

		if(!$bin){
			return $this;
		}

		// try to read the profession and attribute info
		// (pl, profession length code, seems to be unused yet and will always be 00)
		if(!preg_match('/^(?<pl>[01]{2})(?<pri>[01]{4})(?<sec>[01]{4})(?<attrc>[01]{4})(?<attrl>[01]{4})/', $bin, $info)){
			// invalid template
			return $this;
		}

		// cut the 18 bits we've just matched
		$bin = substr($bin, 18);

		// assign professions
		$this->template->primary_profession = $this->bindec_flip($info['pri']);
		$this->template->secondary_profession = $this->bindec_flip($info['sec']);

		// get attributes
		$attr_length = 4 + $this->bindec_flip($info['attrl']);
		for($i = 0, $attr_count = $this->bindec_flip($info['attrc']); $i < $attr_count; $i++){
			if(!preg_match('/^(?<id>[01]{'.$attr_length.'})(?<val>[01]{4})/', $bin, $attributes)){
				// invalid attributes
				return $this;
			}

			// cut the current attribute's bits
			$bin = substr($bin, 4 + $attr_length);

			$this->template->attributes[$this->bindec_flip($attributes['id'])] = $this->bindec_flip($attributes['val']);
		}

		// get skills
		if(!preg_match('/^(?<length>[01]{4})/', $bin, $skill)){
			// invalid skill length bits
			return $this;
		}

		// cut skill length bits
		$bin = substr($bin, 4);

		$skill_length = 8 + $this->bindec_flip($skill['length']);
		foreach(range(1, 8) as $i){ // skills 1-based
			if(!preg_match('/^(?<id>[01]{'.$skill_length.'})/', $bin, $skill)){
				// invalid skill id
				return $this;
			}

			// cut current skill's bits
			$bin = substr($bin, $skill_length);

			$_skill = new Skill;
			$_skill->id = $this->bindec_flip($skill['id']);
			$this->template->skills[$i] = $_skill;
		}

		$this->template->decode_valid = true;

		return $this;
	}

	/**
	 * @return $this
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 * @todo sort attributes primary asc -> secondary asc
	 */
	public function encode(){
		if(!$this->template instanceof Build){
			throw new GW1DatabaseException('Invalid skill template!');
		}

		// binary string start: type (14,4), version (0,4), profession length code (0,2), each value flipped
		$bin = '0111000000';

		// add professions
		$bin .= $this->decbin_pad($this->template->primary_profession, 4);
		$bin .= $this->decbin_pad($this->template->secondary_profession, 4);

		// add attribute count
		$bin .= $this->decbin_pad(count($this->template->attributes), 4);

		// determine attribute pad size
		$attr_pad = 5;

		foreach(array_keys($this->template->attributes) as $id){
			if($id >= 32){
				$attr_pad = 6;
				break;
			}
		}

		// add attribute length code
		$bin .= $this->decbin_pad($attr_pad - 4, 4);

		// add attribute ids and corresponding values
		foreach($this->template->attributes as $id => $value){
			$bin .= $this->decbin_pad($id, $attr_pad);
			$bin .= $this->decbin_pad($value, 4);
		}

		// determine skill pad size
		$skill_pad = 9;
		$skill_id_max = 512;
		foreach($this->template->skills as $_skill){
			if($_skill->id >= $skill_id_max){
				$skill_pad = 1 + floor(log($_skill->id, 2));
				$skill_id_max = pow(2, $skill_pad);
			}
		}

		// add skill length code
		$bin .= $this->decbin_pad($skill_pad - 8, 4);

		// add skill ids
		foreach($this->template->skills as $_skill){
			$bin .= $this->decbin_pad($_skill->id, $skill_pad);
		}

		// add one zero value to the binary string
		$bin .= $this->decbin_pad(0, 6);

		$this->template->code_out = $this->template_encode($bin);
		$this->template->encode_valid = (bool)$this->template->code_out;

		return $this;
	}

}
