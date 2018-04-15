<?php
/**
 * Class GW1DB
 *
 * @filesource   GW1DB.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB;

use chillerlan\Database\Database;
use chillerlan\Database\ResultInterface;
use chillerlan\Traits\ContainerInterface;

/**
 */
class GW1DB extends GW1DBAbstract{

	protected $db;

	public function __construct(ContainerInterface $options, Database $db){
		parent::__construct($options);

		$db->connect();

		$this->db = $db;
	}

	public function getSkill(int $skill_id){

		$q = $this->db->select
			->from([
				'skilldata' => TABLE_SKILLDATA,
				'skilldesc' => TABLE_SKILLDESC_EN,
			])
			->where('skilldata.id', 'skilldesc.id', '=', false)
			->where('skilldata.id', $skill_id)
			->query();

		if($q instanceof ResultInterface && $q->count() > 0){
			return $q[0];
		}

		return null;
	}

	public function getSkills(array $skill_ids){
		// TODO: Implement getSkills() method.
	}
}
