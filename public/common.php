<?php
/**
 *
 * @filesource   common.php
 * @created      26.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBwww;

use chillerlan\Database\{Database, Drivers\MySQLiDrv};
use chillerlan\DotEnv\DotEnv;
use chillerlan\GW1DB\GW1DBOptions;
use chillerlan\HTTP\{Psr18\CurlClient, HTTPOptionsTrait};
use chillerlan\SimpleCache\MemoryCache;
use Psr\Log\AbstractLogger;

mb_internal_encoding('UTF-8');

const DIR_CFG = __DIR__.'/../config';

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
];

$options = new class($o) extends GW1DBOptions{
	use HTTPOptionsTrait;
};

$logger = new class() extends AbstractLogger{
	public function log($level, $message, array $context = []){
		echo sprintf('[%s][%s] %s', date('Y-m-d H:i:s'), substr($level, 0, 4), trim($message))."\n";
	}
};

$http  = new CurlClient($options);
$cache = new MemoryCache;
$db    = new Database($options, $cache);

$db->connect();


/**
 * @param array $response
 */
function send_json_response(array $response){
	header('Content-type: application/json;charset=utf-8;');
	exit(json_encode($response, JSON_PRETTY_PRINT));
}

