<?php
/**
 *
 * @filesource   Player.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Pawned
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Pawned;

/**
 * Class Player
 */
class Player{

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 */
	public $flags;

	/**
	 * @var string
	 */
	public $skills;

	/**
	 * @var string
	 */
	public $equipment;

	/**
	 * @var array
	 */
	public $weaponsets = [];

}
