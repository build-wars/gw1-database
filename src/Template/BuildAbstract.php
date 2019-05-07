<?php
/**
 * Class BuildAbstract
 *
 * @filesource   BuildAbstract.php
 * @created      11.05.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

/**
 */
abstract class BuildAbstract extends TemplateAbstract implements BuildInterface{

	/**
	 * @var string
	 */
	protected const base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

	/**
	 * template type number
	 * 0, 14 -> skill
	 * 1, 15 -> equipment
	 *
	 * @var int
	 */
	protected $template_type;

	protected $code;
	protected $name;
	protected $desc;

	/**
	 * BuildAbstract constructor.
	 *
	 * @param string|null $lang
	 */
	public function __construct(string $lang = null){
		$this->setLang($lang ?? 'en');
	}

	/**
	 * @param string $chr
	 *
	 * @return int|bool
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
	 * @return string
	 */
	protected function decbin_pad(int $dec, int $padding):string {
		$bin = $this->decbin_flip($dec);

		if($padding < strlen($bin)){
			return '';
		}

		return str_pad($bin, $padding, '0');
	}

	/**
	 * @param string $template
	 *
	 * @return string
	 */
	protected function tpl_decode(string $template):?string {
		// nasty fix for urlencode
		$template = str_replace(' ', '+', trim($template));

		if(empty($template)){
			// invalid base64 template
			return null;
		}

		$bin = '';

		foreach(preg_split('//', $template, -1, PREG_SPLIT_NO_EMPTY) as $chr){
			$dec = $this->base64_ord($chr);

			//invalid character
			if($dec === false){
				return null;
			}

			$bin .= str_pad($this->decbin_flip($dec), 6, '0');
		}
		// get the first 4 bits and decide what to do
		$this->template_type = $this->bindec_flip(substr($bin, 0, 4));

		// new format, remove leading template type and version number
		if(in_array($this->template_type, [14, 15], true)){
			return substr($bin, 8);
		}
		// old format prior to April 5, 2007, remove version number
		elseif(in_array($this->template_type, [0, 1], true)){
			return substr($bin, 4);
		}

		return null;
	}

	/**
	 * @param string $bin
	 *
	 * @return string
	 */
	protected function tpl_encode(string $bin):?string{

		if(empty($bin)){
			// invalid binary template
			return null;
		}

		$template_code = array_map(function($b){
			return $this::base64[$this->bindec_flip($b)];
		}, str_split($bin, 6));

		return implode('', $template_code);
	}

	/**
	 * @param string $name
	 *
	 * @return \chillerlan\GW1DB\Template\BuildInterface
	 */
	public function setName(string $name):BuildInterface{
		$this->name = $name;

		return $this;
	}

	/**
	 * @param string $desc
	 *
	 * @return \chillerlan\GW1DB\Template\BuildInterface
	 */
	public function setDescription(string $desc):BuildInterface{
		$this->desc = $desc;

		return $this;
	}

}
