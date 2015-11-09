<?php
/**
 * @filesource   EquipmentItem.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Template
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Template;

/**
 * Class EquipmentItem
 */
class EquipmentItem{

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
