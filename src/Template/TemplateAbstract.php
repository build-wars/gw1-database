<?php
/**
 * Class TemplateAbstract
 *
 * @filesource   TemplateAbstract.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

abstract class TemplateAbstract implements TemplateInterface{

	/**
	 * @var string
	 */
	public const base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

	/**
	 * template type number
	 * 0, 14 -> skill
	 * 1, 15 -> equipment
	 *
	 * @var int
	 */
	protected $type;

	/**
	 * @param string $chr
	 *
	 * @return bool|int
	 */
	protected function base64_ord($chr){
		return strpos($this::base64, $chr, 0);
	}

	/**
	 * @param int $ord
	 *
	 * @return string
	 */
	protected function base64_chr($ord){
		return substr($this::base64, $ord, 1);
	}

	/**
	 * @param string $bin
	 *
	 * @return int
	 */
	protected function bindec_flip(string $bin){
		return bindec(strrev($bin));
	}

	/**
	 * @param int $dec
	 *
	 * @return string
	 */
	protected function decbin_flip(int $dec){
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
	 * @param string $template
	 *
	 * @return string
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	protected function tpl_decode(string $template):string {
		// nasty fix for urlencode
		$template = str_replace(' ', '+', trim($template));

		if(empty($template)){
			throw new TemplateException('decode: invalid base64 template');
		}

		$bin = '';

		foreach(preg_split('//', $template, -1, PREG_SPLIT_NO_EMPTY) as $chr){
			$dec = $this->base64_ord($chr);

			//invalid character
			if($dec === false){
				throw new TemplateException('decode: invalid character');
			}

			$bin .= str_pad($this->decbin_flip($dec), 6, '0');
		}

		// get the first 4 bits and decide what to do
		$this->type = $this->bindec_flip(substr($bin, 0, 4));

		// new format, remove leading template type and version number
		if(in_array($this->type, [14, 15], true)){
			$bin = substr($bin, 8);
		}
		// old format prior to April 5, 2007, remove version number
		elseif(in_array($this->type, [0, 1], true)){
			$bin = substr($bin, 4);
		}

		return $bin;
	}

	/**
	 * @param string $bin
	 *
	 * @return string
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	protected function tpl_encode(string $bin):string{

		if(empty($bin)){
			throw new TemplateException('encode: invalid binary template');
		}

		$template_code = array_map(function($b){
			return $this::base64[$this->bindec_flip($b)];
		}, str_split($bin, 6));

		return implode('', $template_code);
	}


}
