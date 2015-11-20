<?php
/**
 * Class Build
 *
 * @filesource   Build.php
 * @created      05.11.2015
 * @package      chillerlan\GW1Database\Skills
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Skills;

use chillerlan\GW1Database\Template\SetBase;

/**
 * Build template
 */
class Build extends SetBase{

	/**
	 * @var int
	 */
	public $primary_profession;

	/**
	 * @var int
	 */
	public $secondary_profession;

	/**
	 * @var array
	 */
	public $attributes = [];

	/**
	 * @var array
	 */
	public $skills = [];

	/**
	 * @var array
	 */
	public $skill_search = [];

	/**
	 * @var array
	 */
	public $skills_db = [];
}
