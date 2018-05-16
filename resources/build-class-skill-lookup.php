<?php
/**
 * @filesource   build-skill-lookup.php
 * @created      26.04.2018
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

foreach(['de', 'en'] as $lang){

	$q = $db->select
		->from(['gw1_skilldesc_'.$lang])
		->query('id')
		->__map(function($skill, $id){
			return mb_strtolower(trim(str_replace(['"', '!'], '', $skill->pve_name)));
		})
	;

	$l = array_merge($l, array_flip($q));
}

// @todo: add custom skillnames here

$l['variable'] = 0;
$l['variabel'] = 0; // wt:1571
$l['utility']  = 0; // wt:1599
$l['rezz']  = 0; // wt:1572

ksort($l);

$content = [];

foreach($l as $s => $i){

	if(in_array($i, [1949,1950,1951,1952,1953,1954,1955,1957,2051,], true)){ // not shadow refuge -> 1948
		$content[] = "'".addslashes(str_replace(' (luxon)', '', $s))."'=>$i,";
	}

	$content[] = "'".addslashes($s)."'=>$i,";
}
// @todo gwshack lookup
$content = [
	'<?php // don\'t look at it!',
	'namespace chillerlan\\GW1DB\\Data;',
	'class GWSkillLookup {',
	'public const skill2id = [',
	implode(PHP_EOL, $content),
	'];}',
];


file_put_contents(__DIR__.'/../src/Data/GWSkillLookup.php', implode(PHP_EOL, $content).PHP_EOL);
