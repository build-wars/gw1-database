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
use chillerlan\HTTP\TinyCurlClient;
use chillerlan\Logger\Log;
use chillerlan\Logger\LogOptionsTrait;
use chillerlan\Logger\Output\ConsoleLog;
use chillerlan\SimpleCache\Cache;
use chillerlan\SimpleCache\Drivers\MemoryCacheDriver;
use chillerlan\TinyCurl\Request;
use chillerlan\TinyCurl\RequestOptions;
use chillerlan\TinyCurl\RequestOptionsTrait;
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
	// RequestOptions
	'ca_info'     => DIR_CFG.'/cacert.pem',
	'user_agent'  => 'GW1DB/1.0.0 +https://github.com/codemasher/gw1-database',
	// LogOptions
	'minLogLevel' => 'debug',
];

$options = new class($o) extends ContainerAbstract{
	use DatabaseOptionsTrait, RequestOptionsTrait, LogOptionsTrait;

	// ...
};

$logger = new Log;
$logger->addInstance(new ConsoleLog($options), 'console');

$http  = new TinyCurlClient($options, new Request($options));
$cache = new Cache(new MemoryCacheDriver);
$db    = new Database($options, $cache, $logger);

$db->connect();
