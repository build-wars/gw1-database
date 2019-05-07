<?php
/**
 * @filesource   build-skilldb.php
 * @created      14.04.2018
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

foreach(LANGUAGES as $lng){
	$lang[$lng] = $db->select
		->from([constant('TABLE_SKILLDESC_'.strtoupper($lng))])
		->query('id')
	;
}

$types = $db->select->cols(['en' => ['name_en'], 'de' => ['name_de']])->from([TABLE_SKILLTYPES])->query()->__toArray();

// THERE BE DRAGONS
$skilldb = $db->select
	->from([TABLE_SKILLDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
	->__map(function(ResultInterface $skill, int $id) use ($logger, $lang, $types){
		$sk = $skill->__toArray();
		$s = [];

		// common properties
		foreach(['id', 'campaign', 'profession', 'attribute', 'elite', 'rp', 'player', 'split'] as $prop){
			$s[$prop] = $skill->{$prop};

			if(in_array($prop, ['elite', 'rp', 'player', 'split'], true)){
				$s[$prop] = (bool)$skill->{$prop};
			}
			elseif($prop === 'profession'){
				$s[$prop.'_name'] = GWDataMisc::professions[$skill->{$prop}]['name'];
				$s[$prop.'_abbr'] = GWDataMisc::professions[$skill->{$prop}]['abbr'];
				unset($s[$prop.'_name']['fr'], $s[$prop.'_abbr']['fr']); // @todo
			}
			elseif($prop === 'attribute'){
				$s[$prop.'_name'] = GWDataMisc::attributes[$skill->{$prop}]['name'];
				unset($s[$prop.'_name']['fr']); // @todo
			}
			elseif($prop === 'campaign'){
				$s[$prop.'_name'] = GWDataMisc::campaigns[$skill->{$prop}]['name']['en'];
			}

			unset($sk[$prop]);
		}

		// split skill properties
		foreach($sk as $n => $k){
			[$mode, $prop] = explode('_', $n, 2);

			$s[$mode][$prop] = intval($k);
			if($prop === 'type'){
				$s[$mode][$prop.'_name'] = $types[$k] ;
			}

			if($prop === 'activation'){
				$s[$mode][$prop] = floatval($k);
				$s[$mode][$prop.'_str'] = (string)trim(str_replace(['.25', '.50', '.75'], ['&frac14;', '&frac12;', '&frac34;'], $k), '0.');
			}
		}

		// language string
		foreach(['pve', 'pvp'] as $mode){
			foreach(['name', 'desc', 'concise'] as $prop){
				foreach(LANGUAGES as $l){
					$s[$mode][$prop][$l] =$lang[$l][$id]->{$mode.'_'.$prop};
#					$s[$mode][$prop][$l] = str_replace(['<i>', '</i>'], ['<em>', '</em>'], $lang[$l][$id]->{$mode.'_'.$prop});
				}
			}

		}

		// @todo image
		$s['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(DIR_IMG.'/skills/64/'.$id.'.png'));

		// unset pvp if it's not a split skill
		if(!(bool)$s['split']){
			$s['pvp'] = null;
		}

		// dump the content
		file_put_contents(DIR_JSON.'/skills/'.$id.'.json', str_replace('    ', "\t", json_encode($s, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRESERVE_ZERO_FRACTION)));

		// unset stuff for the full db
		unset($s['image'], $s['campaign_name'],  $s['profession_name'], $s['profession_abbr'], $s['attribute_name'], $s['pve']['type_name'], $s['pvp']['type_name']);
		$logger->info('json #'.$s['id'].': '.$s['pve']['name']['en']);
		return $s;
	})
;

$skilldbPHP = [];

foreach($skilldb as $id => $skill){
	$c = [];
	$pvx = ['pve' => [], 'pvp' => []];

	foreach(['campaign', 'profession', 'attribute'] as $i){
		$c[] = sprintf("'%s'=>%d", $i, $skill[$i]);//substr($i, 0, 2)
	}

	foreach(['elite', 'split'] as $i){//'rp',
		$c[] = sprintf("'%s'=>%s", $i, $skill[$i] === true ? 'true' : 'false');//substr($i, 0, 2)
	}

	foreach(['pve', 'pvp'] as $m){

		if($m === 'pvp' && $skill['split'] !== true){
			continue;
		}

		foreach($skill[$m] as $k => $i){

			foreach(['type', 'upkeep', 'energy', 'activation', 'recharge', 'adrenaline', 'sacrifice', 'overcast'] as $p2){
				$pvx[$m][$p2] = sprintf("'%s'=>%s", $p2, $skill[$m][$p2]);//substr($p2, 0, 2)
			}

			foreach(['name', 'desc', 'concise'] as $p2){
				$x = [];

				foreach(LANGUAGES as $l){
					$x[] = sprintf("'%s'=>'%s'", $l, str_replace("'", "\\'", $skill[$m][$p2][$l]));
				}

				$pvx[$m][$p2] = "'$p2'=>[".implode(',', $x).']';
			}
		}
	}

	$skilldbPHP[] = $id.'=>['.implode(',', $c).",'pve'=>[".implode(',', $pvx['pve'])."],'pvp'=>".($skill['split'] === true ? '['.implode(',', $pvx['pvp']).']' : 'null').'],';
}

file_put_contents(DIR_JSON.'/skilldb.json', str_replace('    ', "\t", json_encode($skilldb, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRESERVE_ZERO_FRACTION)));

$content = [
	'<?php // THERE BE DRAGONS',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWSkillDB {',
	'public const id2skill = [',
	implode(PHP_EOL, $skilldbPHP),
	'];}',
];

file_put_contents(__DIR__.'/../src/Data/GWSkillDB.php', implode(PHP_EOL, $content).PHP_EOL);

unset($lang, $skilldb, $skilldbPHP);

### script end ###
