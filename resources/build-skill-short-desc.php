<?php
/**
 * @filesource   build-skill-short-desc.php
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

/** @var \chillerlan\HTTP\HTTPClientInterface $http */
$http = null;

require_once __DIR__.'/build-common.php';

foreach(['en'] as $lang){ //'de',
	$desc_table = constant('TABLE_SKILLDESC_'.strtoupper($lang));

	$skilldata = $db->select
		->from([$desc_table])
		->where('id', 0, '>')
#		->where('pve_desc_short', '') // likely failed requests
		->query();


	foreach($skilldata as $skill){
		$values = [
			'pve_desc_short' => call_user_func(__NAMESPACE__.'\\get_short_desc_'.$lang, $skill['pve_name'], $skill['id']),
			'pvp_desc_short' => !empty($skill['pvp_name']) ? call_user_func(__NAMESPACE__.'\\get_short_desc_'.$lang, $skill['pvp_name'], $skill['id']) : '',
		];

		$db->update->table($desc_table)->set($values)->where('id', $skill['id'])->query();
		$logger->info($values['pve_desc_short']);

		if(!empty($values['pvp_desc_short'])){
			$logger->info($values['pvp_desc_short']);
		}
	}

}


### script end ###

/**
 * @param string $skill
 * @param int    $id
 *
 * @return string
 *
 * @link http://xkcd.com/208
 */
function get_short_desc_en($skill, $id){
	global $http, $logger;

	$logger->info($skill);

	// fix for pve faction skills
	$skill = preg_replace('/(\s\((Kurzick|Luxon)\))/', '', $skill);
	// fix for some warrior shouts
	$skill = in_array($id, [316,333,343,348,364,365,366,367,368]) ? preg_replace('/([^\(\)]+)(\s\(PvP\))?$/i', '"$1"$2', $skill) : $skill;
	// get the page content
	$p = [
		'format' => 'json',
		'action' => 'query',
		'prop' => 'revisions',
		'rvprop' => 'content',
		'titles' => $skill,
	];

	$str = $http->request('https://wiki.guildwars.com/api.php', $p);

	$logger->info($str->url);
	// i don't even try to find the desired array key
	$str = print_r($str->json_array, true);
	// find all matching pairs of double braces
	preg_match_all('/\{\{(?:(?:[^\{\}]+)|(?R))*\}\}/s', $str, $match, PREG_SET_ORDER);
	//get the content of the infobox
	$match = recursive_array_search('Skill infobox', $match);
	// replace some templates (progression, links, colored text, [sic])
	$s = ['/\{\{gr(?:2)?\|([\+\-\d]+)\|([\d%]+)(?:\|(?:[^\}]+)?)?\}\}/i', '/\[\[[^\[\|]+\|([^\[\|]+)\]\]/', '/\{\{gray\|([^\{\}]+)\}\}/i', '/\{\{sic(?:\|[^\}]+)?\}\}/i'];
	$r = ['$1...$2', '$1', '<i>$1</i>', '<sub>sic</sub>'];
	$match = preg_replace($s, $r, $match[0]);
	// replace spans (caching workaround, already fixed on the wiki)
	$match = preg_replace('#<span[^>]*?>(.*)</span>#i','<i>$1</i>', $match);
	// clean out unwanted braces, double spaces
	$match = str_replace(['{', '}', '[', ']', '  '], ['','','','', ' '], $match);
	// explode along the pipe character
	$match = explode('|', $match);
	// there we are
	$match = recursive_array_search('concise description', $match);
	$match = str_replace(['concise description', '='], '', $match);
	// strip out the skill type
	$match = preg_replace('/^(Elite\s)?(Not a Skill|Skill|Bow Attack|Melee Attack|Axe Attack|Lead Attack|Off-Hand Attack|Dual Attack|Hammer Attack|Scythe Attack|Sword Attack|Pet Attack|Spear Attack|Chant|Echo|Form|Glyph|Preparation|Binding ritual|Nature ritual|Shout|Signet|Spell|Enchantment spell|Hex Spell|Item Spell|Ward Spell|Weapon Spell|Well Spell|Stance|Trap|Ranged attack|Ebon Vanguard Ritual|Flash Enchantment|Double Enchantment)\.\s/i','', trim($match));
	return $match;
}

// @todo: guildwiki mediawiki api disabled :/
function get_short_desc_de($skill, $id){
	global $http, $logger;

	$logger->info($skill);

	// fix for pve faction skills
	$skill = $skill === 'Schattenzuflucht (Kurzick)' || $skill === 'Schattenzuflucht (Luxon)' ? 'Schattenzuflucht (Rollenspiel-Fertigkeit)' : $skill;
	$skill = preg_replace('/(\s\((Kurzick|Luxon)\))/', '', $skill);

	// get the page content
	$p = [
		'format' => 'json',
		'action' => 'query',
		'prop' => 'revisions',
		'rvprop' => 'content',
	];

	// nasty fix for "Waste Not, Want Not" which returns a HTTP/403
	$skill === 'Spare in der Zeit ...'
		? $p['pageids'] = 28801
		: $p['titles'] = rawurlencode($skill);

	$str = $http->request('http://www.guildwiki.de/wiki/api.php', $p, 'GET');

	$logger->info($str->url);
	// i don't even try to find the desired array key
	$str = print_r($str->json_array, true);
	// strip out some weird braces which break the regex, also replace [sic]
	$str = str_replace(['{{pipe}}}', '{{{pipe}}', '{{sic}}'], ['', '', '<sub>sic</sub>]'], $str);
	// find all matching pairs of double braces
	preg_match_all('/\{\{(?:(?:[^\{\}]+)|(?R))*\}\}/s', $str, $match, PREG_SET_ORDER);
	//get the content of the infobox
	$match = recursive_array_search('Infobox Fertigkeit', $match);
	// replace some templates (progression, links, colored text)
	$s = ['/\{\{[p1-2]+\|([\+\-\d]+)\|([\d%]+)(?:\|(?:[^\}]+))?\}\}/i', '/\[\[[^\[\|]+\|([^\[\|]+)\]\]/', '/\{\{[a-z]+\|([^\{\}]+)\}\}/i'];
	$r = ['$1...$2', '$1', '<i>$1</i>'];
	$match = preg_replace($s, $r, $match[0]);
	// clean out unwanted braces and stuff
	$match = str_replace(['{', '}', '[', ']', 'kurzbeschreibungstyp'], '', $match);
	// explode along the pipe character
	$match = explode('|', $match);
	// there we are
	$match = recursive_array_search('kurzbeschreibung', $match);
	$match = str_replace(['kurzbeschreibung', '='], '', $match);
	return trim($match);
}


/**
 * @param string $needle
 * @param array  $haystack
 *
 * @return mixed
 *
 * @link http://php.net/manual/function.array-search.php#91365
 */
function recursive_array_search($needle, $haystack){
	foreach($haystack as $key => $value){
		if($needle === $value || (is_string($value) && strripos($value, $needle) !== false) || (is_array($value) && recursive_array_search($needle, $value) !== false)){
			return $value;
		}
	}
	return false;
}
