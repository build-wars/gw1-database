<?php
/**
 * @filesource   GW1DBTest.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DBTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest;

use chillerlan\Database\Database;
use chillerlan\Database\Drivers\MySQLiDrv;
use chillerlan\GW1DB\GW1DB;
use chillerlan\GW1DB\GW1DBOptions;
use chillerlan\Traits\DotEnv;
use PHPUnit\Framework\TestCase;

/**
 * Class GW1DBTest
 */
class GW1DBTest extends TestCase{

	/**
	 * @var \chillerlan\GW1DB\GW1DataInterface
	 */
	protected $gw1db;

	public function setUp(){
		$env = (new DotEnv(__DIR__.'/../config', '.env', false))->load();

		$o = [
			// DatabaseOptions
			'driver'   => MySQLiDrv::class,
			'host'        => $env->DB_HOST,
			'port'        => $env->DB_PORT,
			'socket'      => $env->DB_SOCKET,
			'database'    => $env->DB_DATABASE,
			'username'    => $env->DB_USERNAME,
			'password'    => $env->DB_PASSWORD,
			// gw1db
			'language' => 'de',
		];

		$options = new GW1DBOptions($o);

		$this->gw1db = new GW1DB($options, new Database($options));
	}

	public function testGetSkill(){
		$x = $this->gw1db->getSkill(42);

		var_dump($x);
		$this->markTestIncomplete();
	}
}
