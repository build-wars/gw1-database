<?php
/**
 * @filesource   GWBBParser.php
 * @created      07.11.2015
 * @package      chillerlan\GW1Database\bbcode
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\bbcode;

use chillerlan\bbcode\Parser;
use chillerlan\GW1Database\bbcode\GWBBParserOptions;

/**
 * Class GWBBParser
 */
class GWBBParser extends Parser{

	/**
	 * GWBBParser constructor.
	 *
	 * @param \chillerlan\GW1Database\bbcode\GWBBParserOptions $options
	 */
	public function __construct(GWBBParserOptions $options = null){
		parent::__construct(!$options ? new GWBBParserOptions : $options);
	}

	/**
	 * Encodes a BBCode string to HTML (or whatevs)
	 *
	 * @param string $bbcode
	 *
	 * @return string
	 */
	public function parse($bbcode){
		// run the preparser before the sanitizer here.
		$bbcode = $this->_parser_extension->pre($bbcode);

		if($this->options->sanitize){
			$bbcode = $this->_base_module->sanitize($bbcode);
		}

		$this->bbcode_pre = $bbcode;

		$bbcode = preg_replace('#\[('.$this->options->singletags.')((?:\s|=)[^]]*)?]#is', '[$1$2][/$1]', $bbcode);
		$bbcode = str_replace(["\r", "\n"], ['', $this->options->eol_placeholder], $bbcode);
		$bbcode = $this->_parse($bbcode);
		$bbcode = $this->_parser_extension->post($bbcode);
		$bbcode = str_replace($this->options->eol_placeholder, $this->options->eol_token, $bbcode);

		return $bbcode;
	}


}
