<?php
/**
 * @filesource   build-skill-update.php
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

// the skill databases for each language. more to come... probably never.
const skilldb = [
	'de' => [
		'pve' => 'http://pawned.gwcom.de/skilldata/deutsch/v1/gw_csv_str.csv',
		'pvp' => 'http://pawned.gwcom.de/skilldata/deutsch/v1/gw_pvp_csv_str.csv'
	],
	'en' => [
		'pve' => 'http://pawned.gwcom.de/skilldata/englisch/v1/englishPVE.csv',
		'pvp' => 'http://pawned.gwcom.de/skilldata/englisch/v1/englishPVP.csv'
	]
];

// so lets fetch the skilldata
$skilldata = [];
$skilldesc = [];

/*
 * paw-ned² skilldb schema
 *
 * 0 = id
 * 1 = name
 * 2 = name2 (de/en)
 * 3 = desc
 * 4 = campaign
 * 5 = attribute
 * 6 = type
 * 7 = profession
 * 8 = upkeep
 * 9 = energy
 * 10 = activation
 * 11 = recharge
 * 12 = adrenaline
 * 13 = sacrifice
 * 14 = elite
 * 15 = pve
 * 16 = overcast
 * 17 = ?
 * 18 = ?
 * 19 = empty
 */

foreach(skilldb as $lang => $modes){

	foreach($modes as $mode => $url){
		$logger->info('preparing skilldata '.$mode.'-'.$lang);

		$data = file_get_contents($url);
		$data = explode("\n", $data);

		$skilldesc[$lang][$mode] = [];

		// we need the skilldata just once
		if($lang === 'de'){
			$skilldata[$mode] = [];
		}

		foreach($data as $skill){
			$skill = explode(';', $skill);
			if(is_array($skill) && !empty($skill[0])){
				// unset the empty/unnessecary fields
				unset($skill[2], $skill[17], $skill[18], $skill[19]);

				// utf8_encode the data
				$skill = utf8_arr($skill);

				// name and description(s)
				$skilldesc[$lang][$mode][(int)$skill[0]] = [
					$skill[0],
					$skill[1],
					$skill[3],
				];

				// skill data
				if($lang === 'de'){
					// unset the desc
					unset($skill[3]);
					$skilldata[$mode][] = $skill;
				}

			}
		}
	}
}

// skill number zero is the "unknown skill"
$values = [[
	'id'             => 0,
	'campaign'       => 0,
	'profession'     => 0,
	'attribute'      => -1,
	'elite'          => 0,
	'pve_only'       => 0,
	'pvp_split'      => 0,
	'pve_type'       => 0,
	'pve_upkeep'     => 0,
	'pve_energy'     => 0,
	'pve_activation' => 0,
	'pve_recharge'   => 0,
	'pve_adrenaline' => 0,
	'pve_sacrifice'  => 0,
	'pve_overcast'   => 0,
	'pvp_type'       => 0,
	'pvp_upkeep'     => 0,
	'pvp_energy'     => 0,
	'pvp_activation' => 0,
	'pvp_recharge'   => 0,
	'pvp_adrenaline' => 0,
	'pvp_sacrifice'  => 0,
	'pvp_overcast'   => 0,
]];

// create the skilldata table
foreach($skilldata['pve'] as $key => $skill){

	if($skill[0] !== $skilldata['pvp'][$key][0]){
		/** @noinspection PhpUnhandledExceptionInspection */
		throw new \Exception('skill mismatch');
	}

	$values[(int)$skill[0]] = [
		'id'             => (int)$skill[0],
		'campaign'       => (int)$skill[4],
		'profession'     => (int)$skill[7],
		'attribute'      => (int)$skill[5],
		'elite'          => (int)$skill[14],
		'pve_only'       => (bool)$skill[15],
		'pvp_split'      => $skill[1] !== $skilldata['pvp'][$key][1],
		'pve_type'       => (int)$skill[6],
		'pve_upkeep'     => (int)$skill[8],
		'pve_energy'     => (int)$skill[9],
		'pve_activation' => (float)$skill[10],
		'pve_recharge'   => (int)$skill[11],
		'pve_adrenaline' => (int)$skill[12],
		'pve_sacrifice'  => (int)$skill[13],
		'pve_overcast'   => (int)$skill[16],
		'pvp_type'       => (int)$skilldata['pvp'][$key][6],
		'pvp_upkeep'     => (int)$skilldata['pvp'][$key][8],
		'pvp_energy'     => (int)$skilldata['pvp'][$key][9],
		'pvp_activation' => (float)$skilldata['pvp'][$key][10],
		'pvp_recharge'   => (int)$skilldata['pvp'][$key][11],
		'pvp_adrenaline' => (int)$skilldata['pvp'][$key][12],
		'pvp_sacrifice'  => (int)$skilldata['pvp'][$key][13],
		'pvp_overcast'   => (int)$skilldata['pvp'][$key][16],
	];

}

ksort($values);

$db->truncate->table(TABLE_SKILLDATA)->query();
$db->insert->into(TABLE_SKILLDATA)->values($values)->multi();
$db->raw('OPTIMIZE TABLE '.TABLE_SKILLDATA);

#file_put_contents(DIR_JSON.'/'.TABLE_SKILLDATA.'.json', json_encode($values, JSON_PRETTY_PRINT));

$logger->info('created table: '.TABLE_SKILLDATA);

// ...and the names/descriptions
foreach(skilldb as $lang => $v){

	$values = [[
		'id' => 0,
		'pve_name' => '',
		'pve_desc' => '',
		'pvp_name' => '',
		'pvp_desc' => '',
	]];

	foreach($skilldesc[$lang]['pve'] as $key => $skill){
		if($skill[0] === $skilldesc[$lang]['pvp'][$key][0]){

			$pvp_split = $skilldesc[$lang]['pvp'][$key][1] !== $skill[1];

			$values[$skill[0]] = [
				'id' => $skill[0],
				'pve_name' => $skill[1],
				'pve_desc' => $skill[2],
				'pvp_name' => $pvp_split ? $skilldesc[$lang]['pvp'][$key][1] : '',
				'pvp_desc' => $pvp_split ? $skilldesc[$lang]['pvp'][$key][2] : '',
			];
		}
	}

	ksort($values);

	$desc_table = constant('TABLE_SKILLDESC_'.strtoupper($lang));

	$db->truncate->table($desc_table)->query();
	$db->insert->into($desc_table)->values($values)->multi();
	$db->raw('OPTIMIZE TABLE '.$desc_table);

	$logger->info('created table: '.$desc_table);
}

unset($skilldata, $skilldesc, $values);

### script end ###

/**
 * @param mixed $data
 *
 * @return array|string
 */
function utf8_arr($data){

	if(is_array($data)){

		foreach($data as $key => $value){
			$data[$key] = utf8_arr($value);
		}

		return $data;
	}

	return utf8_encode($data);
}
