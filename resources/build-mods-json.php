<?php
/**
 * @filesource   build-mods-json.php
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
		->from([constant('TABLE_MODDESC_'.strtoupper($lng))])
		->query('id')
	;
}

$db->select
	->from([TABLE_MODDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
	->__each(function($item, $id) use ($logger, $lang){
		$m = $item->__toArray();

		// @todo
		$m['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(__DIR__.'/img/mods/'.$m['img_id'].'.png'));

		foreach(['de', 'en'] as $lng){
			$m['name'][$lng] = $lang[$lng][$id]->name;
			$m['desc'][$lng] = $lang[$lng][$id]->desc;
			$m['base'][$lng] = $lang[$lng][$id]->base;
			$m['ext'][$lng]  = $lang[$lng][$id]->ext;
		}

		$logger->info($m['name']['en']);
		file_put_contents(DIR_JSON.'/mods/'.$id.'.json', str_replace('    ', "\t", json_encode($m, JSON_PRETTY_PRINT)));
	});


unset($lang);

### script end ###
