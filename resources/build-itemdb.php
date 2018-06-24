<?php
/**
 * @filesource   build-itemdb.php
 * @created      15.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBBuild;

use chillerlan\Database\ResultInterface;
use chillerlan\GW1DB\Data\GWDataMisc;

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

$item_types   = array_combine(array_column(GWDataMisc::ITEM_TYPES, 'en'), array_keys(GWDataMisc::ITEM_TYPES));
$item_effects = array_combine(array_column(GWDataMisc::ITEM_EFFECT, 'en'), array_keys(GWDataMisc::ITEM_EFFECT));

$itemdb = $db->select
	->from([TABLE_ITEMDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
	->__map(function(ResultInterface $item, $id) use ($logger, $lang, $item_types, $item_effects){
		$i = $item->__toArray();

		$i['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(DIR_IMG.'/items/'.$id.'.png'));
		$i['type'] = $item_types[$lang['en'][$id]->type];
		$i['effect'] = $lang['en'][$id]->base_type === '-' ? null : $item_effects[$lang['en'][$id]->base_type];
		$i['base_value'] = $i['base_value'] === '-' ? null : $i['base_value'];

		foreach(['de', 'en'] as $lng){
			$i['name'][$lng]      = $lang[$lng][$id]->name;
			$i['wiki'][$lng]      = $lang[$lng][$id]->wiki;
		}

		$logger->info($i['name']['en']);
		file_put_contents(DIR_JSON.'/items/'.$id.'.json', str_replace('    ', "\t", json_encode($i, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRESERVE_ZERO_FRACTION)));

		unset($i['image'],$i['wiki']);
		return $i;
	});


file_put_contents(DIR_JSON.'/itemdb.json', str_replace('    ', "\t", json_encode($itemdb, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRESERVE_ZERO_FRACTION)));

$itemdbPHP = [];
foreach($itemdb as $id => $item){
	$c = [];

	foreach(['type', 'profession', 'attribute', 'mods', 'effect'] as $i){
		$c[] = sprintf("'%s'=>%d", $i, $item[$i]);
	}

	$c[] = sprintf("'base_value'=>%s", $item['base_value'] === null ? 'null' : "'".$item['base_value']."'");

	foreach(['name',] as $p2){
		$x = [];

		foreach(LANGUAGES as $l){
			$x[] = sprintf("'%s'=>'%s'", $l, str_replace("'", "\\'", $item[$p2][$l]));
		}

		$c[] = "'$p2'=>[".implode(',', $x).']';
	}

	$itemdbPHP[] = $id.'=>['.implode(',', $c).'],';
}

$content = [
	'<?php',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWItemDB {',
	'public const id2item = [',
	implode(PHP_EOL, $itemdbPHP),
	'];}',
];

file_put_contents(__DIR__.'/../src/Data/GWItemDB.php', implode(PHP_EOL, $content).PHP_EOL);

unset($itemdb, $itemdbPHP, $lang);

### script end ###
