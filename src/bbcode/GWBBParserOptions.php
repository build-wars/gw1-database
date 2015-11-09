<?php
/**
 * @filesource   GWBBParserOptions.php
 * @created      07.11.2015
 * @package      chillerlan\GW1Database\bbcode
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\bbcode;

use chillerlan\bbcode\ParserOptions;
use chillerlan\GW1Database\bbcode\GWBBParserExtension;
use chillerlan\GW1Database\bbcode\Html5\GWBBHtml5BaseModule;
use chillerlan\GW1Database\Database\Connectors\ChillerlanFramework;

/**
 * Class GWBBParserOptions
 */
class GWBBParserOptions extends ParserOptions{

	/**
	 * The base module to use (FQCN)
	 *
	 * @var string
	 */
	public $base_module = GWBBHtml5BaseModule::class;

	/**
	 * The parser extension to use (FQCN)
	 *
	 * @var string
	 */
	public $parser_extension = GWBBParserExtension::class;

	/**
	 * The framework connector (FQCN)
	 *
	 * @var string
	 */
	public $connector = ChillerlanFramework::class;

	/**
	 * The framework connector options. This will be passed as parameter to the constructor of the connector class.
	 *
	 * @var mixed
	 */
	public $connector_options;

	/**
	 * Language [de, en]
	 *
	 * @var string
	 */
	public $lang = 'en';

	/**
	 * The EOL placeholder token
	 *
	 * the GWShack newline token, which is also being used in build descriptions
	 *
	 * @var string
	 */
	public $eol_placeholder = '{br}';

}
