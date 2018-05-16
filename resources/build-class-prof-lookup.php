<?php
/**
 * @filesource   build-class-prof-lookup.php
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
	->cols(['id', 'name_de', 'name_en', 'abbr_en'])
	->from(['gw1_professions'])
	->query('id')
	->__each(function($prof, $id) use (&$l){
		$l[mb_strtolower($prof->name_en)] = $id;
		$l[mb_strtolower($prof->name_de)] = $id;
		$l[mb_strtolower($prof->abbr_en)] = $id;
	})
;

// @todo: custom names
$l['no']    = 0;
$l['none']  = 0;
$l['keine'] = 0;
$l['warr']  = 1;
$l['wald']  = 2;
$l['waldi'] = 2;
$l['mö']    = 3;
$l['nec']   = 4;
$l['nek']   = 4;
$l['mes']   = 5;
$l['ele']   = 6;
$l['assa']  = 7;
$l['rit']   = 8;
$l['ritu']  = 8;
$l['para']  = 9;
$l['derv']  = 10;
$l['derw']  = 10;
#$lookup[''] = ;


ksort($l);

$content = [];

foreach($l as $s => $i){
	$content[] = "'".addslashes($s)."'=>$i,";
}

$content = [
	'<?php // don\'t look at it!',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWProfLookup {',
	'public const prof2id = [',
	implode(PHP_EOL, $content),
	'];}',
];

file_put_contents(__DIR__.'/../src/Data/GWProfLookup.php', implode(PHP_EOL, $content).PHP_EOL);
