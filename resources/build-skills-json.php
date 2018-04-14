<?php
/**
 * @filesource   build-skills-json.php
 * @created      14.04.2018
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

$skills = $db->select
	->from([TABLE_SKILLDATA])
	->orderBy(['id' => 'asc'])
	->query('id')
;

$lang = [];

foreach(['de', 'en'] as $lng){
	$lang[$lng] = $db->select
		->from([constant('TABLE_SKILLDESC_'.strtoupper($lng))])
		->query('id')
	;
}

$skills->__each(function($skill, $id) use ($logger, $lang){
	/** @var \chillerlan\Database\ResultInterface $skill */
	$skill = $skill->__toArray();

	foreach(['id', 'campaign', 'profession', 'attribute', 'elite', 'pve_only', 'pvp_split'] as  $p){
		/** @var array $skill */
		$s[$p] = (int)array_shift($skill);
	}

	// @todo
#	$s['image'] ='data:image/png;base64,'.base64_encode(file_get_contents(__DIR__.'/img/skills/64/'.$id.'.png'));

	foreach($skill as $n => $k){
		$n = explode('_', $n, 2);

		if($n[1] === 'activation'){
			$s[$n[0]][$n[1].'_str'] = $k;
			$k                      = floatval($k);
		}

		$s[$n[0]][$n[1]]  = $k;

		foreach(['de', 'en'] as $l){
			foreach(['name', 'desc', 'desc_short'] as $f){
				$s[$n[0]][$f][$l] = $lang[$l][$id]->{$n[0].'_'.$f};
			}
		}
	}

	if(!(bool)$s['pvp_split']){
		unset($s['pvp']);
	}

	$logger->info($s['pve']['name']['en']);
	file_put_contents(DIR_JSON.'/skills/'.$id.'.json', str_replace('    ', "\t", json_encode($s, JSON_PRETTY_PRINT)));
});

exit;
