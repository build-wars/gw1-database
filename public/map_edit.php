<?php
/**
 *
 * @filesource   map_edit.php
 * @created      13.02.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBwww;

/** @var \chillerlan\Database\Database $db */
$db = null;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/common.php';

try{
	$json = json_decode(file_get_contents('php://input'));

	if(!$json || !isset($json->type) || !isset($json->id) || !in_array($json->type, ['outpost', 'boss'], true)){
		header('HTTP/1.1 400 Bad Request');
		send_json_response(['error' => 'invalid continent', 'type' => '-']);
	}

	$u = $db->update;

	$c = ['coord' => json_encode([intval($json->coord->x), intval($json->coord->y)])];

	if($json->type === 'outpost'){
		$u->table('gw1_outposts')->set($c)->where('outpost_id', $json->id);
	}
	elseif($json->type === 'boss'){
		$u->table('gw1_bosses')->set($c)->where('boss_id', $json->id);
	}


	if(!$u->query()){
		header('HTTP/1.1 500 Internal Server Error');
		send_json_response(['error' => 'db error']);
	}

	send_json_response(['msg' => 'updated:'.$json->type.', id:'.$json->id]);
}
// Pokémon exception handler
catch(\Exception $e){
	header('HTTP/1.1 500 Internal Server Error');
	send_json_response(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
}





