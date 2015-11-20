<?php
/**
 * Class SetBase
 *
 * @filesource   SetBase.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Template
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Template;

/**
 * Template shared properties
 */
class SetBase{

	/**
	 * The template code as base64
	 *
	 * @var string
	 */
	public $code;

	/**
	 * The generated template code as base64
	 *
	 * @var string
	 */
	public $code_out;

	/**
	 * Indicates wether the given template code was valid
	 *
	 * @var bool
	 */
	public $decode_valid = false;

	/**
	 * Indicates wether generated template code was valid
	 *
	 * @var bool
	 */
	public $encode_valid = false;

	/**
	 * @var string
	 */
	public $pcre_match;

	/**
	 * Language [de, en]
	 *
	 * @var string
	 */
	public $lang = 'en';

	/**
	 * SetBase constructor.
	 *
	 * Accept a template code as parameter to simplify decoding
	 *
	 * @param string $code
	 */
	public function __construct($code = null){
		if(!empty($code) && is_string($code)){
			$this->code = $code;
		}
	}

}
