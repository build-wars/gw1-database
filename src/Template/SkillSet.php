<?php
/**
 * Class SkillSet
 *
 * @filesource   SkillSet.php
 * @created      05.11.2015
 * @package      chillerlan\GW1Database\Template
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Template;

use chillerlan\GW1Database\Template\SetBase;

/**
 * Skill template
 */
class SkillSet extends SetBase{

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
