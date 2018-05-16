<?php
/**
 * @filesource   build-class-attr-lookup.php
 * @created      27.04.2018
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

$l = [];

$db->select
	->cols(['id', 'name_de', 'name_en', 'abbr'])
	->from(['gw1_attributes'])
	->query('id')
	->__each(function($prof, $id) use (&$l){

		if($id >= 0){
			$l[mb_strtolower($prof->name_en)] = $id;
			$l[mb_strtolower($prof->name_de)] = $id;
		}

		$l[mb_strtolower($prof->abbr)] = $id;
	})
;

// todo: custom names
$l['fast']   = 0;
$l['insp']   = 3;
$l['curs']   = 7;
$l['soul']   = 6;
$l['bloo']   = 4;
$l['comm']   = 32;
$l['spaw']   = 36;
$l['commu']  = 32;
$l['shadow'] = 31;
$l['crit']   = 35;
$l['dagger'] = 29;
$l['mark']   = 23;
$l['rest']   = 33;
$l['energy'] = 12;
$l['tact']   = 21;
$l['lead']   = 38;
$l['spea']   = 37;
$l['resto']  = 33;
$l['illu']   = 1;
#$lookup[''] = ;

ksort($l);

$content = [];

foreach($l as $s => $i){
	$content[] = "'".str_replace([' ', '-'], '', $s)."'=>$i,";
}

$content = [
	'<?php // don\'t look at it!',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWAttrLookup {',
	'public const attr2id = [',
	implode(PHP_EOL, $content),
	'];}',
];

file_put_contents(__DIR__.'/../src/Data/GWAttrLookup.php', implode(PHP_EOL, $content).PHP_EOL);
