<?php
/**
 * Class GWBBOutput
 *
 * @filesource   GWBBOutput.php
 * @created      26.04.2018
 * @package      chillerlan\GW1DB\GWBBCode
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\GWBBCode;

use chillerlan\BBCode\Output\{
	BBCodeOutputAbstract
};

final class GWBBOutput extends BBCodeOutputAbstract{

	protected $modules = [
		GWBBCodeModule::class,
	];

	protected $eol = '<br/>'.PHP_EOL;
}
