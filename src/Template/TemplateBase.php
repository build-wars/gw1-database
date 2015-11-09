<?php
/**
 * Class TemplateBase
 *
 * @filesource   TemplateBase.php
 * @created      05.11.2015
 * @package      chillerlan\GW1Database\Template
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Template;

use chillerlan\GW1Database\GW1DatabaseException;
use chillerlan\GW1Database\Template\EquipmentSet;
use chillerlan\GW1Database\Template\SetBase;
use chillerlan\GW1Database\Template\SkillSet;

/**
 *
 */
class TemplateBase{

	/**
	 * @var \chillerlan\GW1Database\Template\SetBase
	 */
	protected $template;

	/**
	 * @var string
	 */
	protected $base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

	/**
	 * @param string $bin
	 *
	 * @return int
	 */
	protected function bindec_flip($bin){
		return bindec(strrev($bin));
	}

	/**
	 * @param int $dec
	 *
	 * @return string
	 */
	protected function decbin_flip($dec){
		return strrev(decbin($dec));
	}

	/**
	 * @param int $dec
	 * @param int $padding
	 *
	 * @return string|bool
	 */
	protected function decbin_pad($dec, $padding){
		$bin = $this->decbin_flip($dec);
		if($padding < strlen($bin)){
			return false;
		}

		return str_pad($bin, $padding, '0');
	}

	/**
	 * @param string $chr
	 *
	 * @return bool|int
	 */
	protected function base64_ord($chr){
		return strpos($this->base64, $chr, 0);
	}

	/**
	 * @param int $ord
	 *
	 * @return string
	 */
	protected function base64_chr($ord){
		return substr($this->base64, $ord, 1);
	}

	/**
	 * @return $this
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function template_decode(){
		$code = $this->template->code;

		if(empty($code)){
			throw new GW1DatabaseException('Invalid template!');
		}

		// nasty fix for + signs which represent spaces in URLs
		$code = str_replace(' ', '+', $code);

		$bin = '';
		foreach(preg_split('//', trim($code), -1, PREG_SPLIT_NO_EMPTY) as $char){
			$char_id = strpos($this->base64, $char);

			//invalid character
			if($char_id === false){
				return $this;
			}

			$bin_chunk = $this->decbin_flip($char_id);
			$bin .= str_pad($bin_chunk, 6, '0');
		}

		$this->template->bin_decoded_debug = $bin;

		// get the first 4 bits and decide what to do
		$type = $this->bindec_flip(substr($bin, 0, 4));

		// remove version number
		switch($type){
			// old format prior to April 5, 2007
			case 0:
			case 1:
				$this->template->bin_decoded = substr($bin, 4);
				break;
			// new format
			case 14:
			case 15:
				$this->template->bin_decoded = substr($bin, 8);
				break;
		}

		return $this;
	}

	/**
	 * @return $this
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	protected function template_encode(){
		$bin = $this->template->bin_encoded;

		if(empty($bin)){
			throw new GW1DatabaseException('Invalid template!');
		}

		$template_code = '';
		while(!empty($bin)){
			$template_code .= $this->base64[$this->bindec_flip(substr($bin, 0, 6))];
			$bin = substr($bin, 6);
		}

		$this->template->code_out = $template_code;

		return $this;
	}

}
