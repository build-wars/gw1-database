<?php
/**
 * @filesource   build-common.php
 * @created      14.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBBuild;

use chillerlan\Database\{
	Database, DatabaseOptionsTrait, Drivers\MySQLiDrv
};
use chillerlan\Logger\Log;
use chillerlan\Logger\LogOptionsTrait;
use chillerlan\Logger\Output\ConsoleLog;
use chillerlan\SimpleCache\Cache;
use chillerlan\SimpleCache\Drivers\MemoryCacheDriver;
use chillerlan\Traits\{
	ContainerAbstract, DotEnv
};

mb_internal_encoding('UTF-8');

const DIR_CFG = __DIR__.'/../config';
const DIR_JSON = __DIR__.'/json';

require_once __DIR__.'/../vendor/autoload.php';

$env = (new DotEnv(DIR_CFG, '.env', false))->load();

$o = [
	// DatabaseOptions
	'driver'      => MySQLiDrv::class,
	'host'        => $env->DB_HOST,
	'port'        => $env->DB_PORT,
	'socket'      => $env->DB_SOCKET,
	'database'    => $env->DB_DATABASE,
	'username'    => $env->DB_USERNAME,
	'password'    => $env->DB_PASSWORD,
	// log
	'minLogLevel' => 'debug',
];

$options = new class($o) extends ContainerAbstract{
	use DatabaseOptionsTrait, LogOptionsTrait;

	// ...
};

$logger = new Log;
$logger->addInstance(new ConsoleLog($options), 'console');

$cache = new Cache(new MemoryCacheDriver);

$db = new Database($options, $cache, $logger);
$db->connect();
