<?php
/**
 * @filesource   Item.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Equipment
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Equipment;

/**
 * Class Item
 */
class Item{

	/**
	 * @var int
	 */
	public $type;

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var int
	 */
	public $color;

	/**
	 * @var array
	 */
	public $mods = [];

}
