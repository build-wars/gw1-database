<?php
/**
 * Interface GW1DataInterface
 *
 * @filesource   GW1DataInterface.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB;

interface GW1DataInterface{

	public function getSkill(int $skill_id);
	public function getSkills(array $skill_ids);

}
