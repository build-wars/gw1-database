<?php
/**
 * Class GWBBHtml5BaseModule
 *
 * @filesource   GWBBHtml5BaseModule.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\bbcode\Html5
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\bbcode\Html5;

use chillerlan\bbcode\BBTemp;
use chillerlan\bbcode\Modules\Html5\Html5BaseModule;
use chillerlan\bbcode\Modules\BaseModuleInterface;
use chillerlan\GW1Database\bbcode\Html5\GWBBcode;

/**
 *
 */
class GWBBHtml5BaseModule extends Html5BaseModule implements BaseModuleInterface{

	/**
	 * Constructor
	 *
	 * calls self::set_bbtemp() in case $bbtemp is set
	 * merges the GWBBCode modules into self::$modules
	 *
	 * @param \chillerlan\bbcode\BBTemp $bbtemp
	 */
	public function __construct(BBTemp $bbtemp = null){
		parent::__construct($bbtemp);

		$this->modules = array_merge($this->modules, [
			GWBBcode::class,
		]);
	}

}
