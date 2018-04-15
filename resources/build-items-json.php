<?php
/**
 * @filesource   build-items-json.php
 * @created      15.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBBuild;

/** @var \chillerlan\Database\Database $db */
$db = null;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/build-common.php';

$lang = [];

foreach(['de', 'en'] as $lng){
	$lang[$lng] = $db->select
		->from([constant('TABLE_ITEMDESC_'.strtoupper($lng))])
		->query('id')
	;
}

$db->select
	->from([TABLE_ITEMDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
	->__each(function($item, $id) use ($logger, $lang){
		$i = $item->__toArray();

		// @todo
		$i['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(__DIR__.'/img/items/'.$id.'.png'));

		foreach(['de', 'en'] as $lng){
			$i['name'][$lng]      = $lang[$lng][$id]->name;
			$i['type'][$lng]      = $lang[$lng][$id]->type;
			$i['base_type'][$lng] = $lang[$lng][$id]->base_type;
			$i['wiki'][$lng]      = $lang[$lng][$id]->wiki;
		}

		$logger->info($i['name']['en']);
		file_put_contents(DIR_JSON.'/items/'.$id.'.json', str_replace('    ', "\t", json_encode($i, JSON_PRETTY_PRINT)));
	});


unset($lang);

### script end ###
