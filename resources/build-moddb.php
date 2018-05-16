<?php
/**
 * @filesource   build-moddb.php
 * @created      15.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBBuild;

/** @var \chillerlan\Database\Database $db */
use chillerlan\Database\ResultInterface;
use chillerlan\GW1DB\Data\GWDataMisc;

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

$mod_base  = array_combine(array_column(GWDataMisc::MOD_BASE, 'en'), array_keys(GWDataMisc::MOD_BASE));
$mod_types = array_flip(GWDataMisc::ITEM_MOD_TYPES);

$moddb = $db->select
	->from([TABLE_MODDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
	->__map(function(ResultInterface $item, $id) use ($logger, $lang, $mod_base, $mod_types){
		$m = $item->__toArray();

		$m['type'] = $mod_types[$m['type']];
		$m['base'] = $mod_base[$lang['en'][$id]->base];
		$m['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(DIR_IMG.'/mods/'.$m['img_id'].'.png'));

		foreach(['de', 'en'] as $lng){
			$m['name'][$lng] = $lang[$lng][$id]->name;
			$m['desc'][$lng] = $lang[$lng][$id]->desc;
			$m['ext'][$lng]  = $lang[$lng][$id]->ext;
		}

		$logger->info($m['name']['en']);
		file_put_contents(DIR_JSON.'/mods/'.$id.'.json', str_replace('    ', "\t", json_encode($m, JSON_PRETTY_PRINT)));

		unset($m['image']);

		return $m;
	});

file_put_contents(DIR_JSON.'/moddb.json', str_replace('    ', "\t", json_encode($moddb, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRESERVE_ZERO_FRACTION)));

$moddbPHP = [];

foreach($moddb as $id => $mod){
	$c = [];

	foreach(['profession', 'img_id', 'type', 'base'] as $i){
		$c[] = sprintf("'%s'=>%d", $i, $mod[$i]);
	}

	foreach(['name', 'desc', 'ext'] as $p2){
		$x = [];

		foreach(LANGUAGES as $l){
			$x[] = sprintf("'%s'=>'%s'", $l, str_replace("'", "\\'", $mod[$p2][$l]));
		}

		$c[] = "'$p2'=>[".implode(',', $x).']';
	}

	$moddbPHP[] = $id.'=>['.implode(',', $c).'],';
}

$content = [
	'<?php',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWModDB {',
	'public const id2mod = [',
	implode(PHP_EOL, $moddbPHP),
	'];}',
];

file_put_contents(__DIR__.'/../src/Data/GWModDB.php', implode(PHP_EOL, $content).PHP_EOL);


unset($moddb, $moddbPHP, $lang);

### script end ###
