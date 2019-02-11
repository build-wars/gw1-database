<?php
/**
 *
 * @filesource   geojson.php
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBwww;

use chillerlan\Database\ResultRow;
use chillerlan\GW1DB\Maps\{GeoJSONFeature, GeoJSONFeatureCollection, GWContinentRect};

/** @var \chillerlan\Database\Database $db */
$db = null;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/common.php';


try{
	$json = json_decode(file_get_contents('php://input'));

	if(!$json || !isset($json->continent) || !in_array($json->continent, ['mists', 'tyria', 'cantha', 'elona', 'presearing', 'battleisles'], true)){
		header('HTTP/1.1 400 Bad Request');
		send_json_response(['error' => 'invalid continent', 'trace' => '-']);
	}

	$featureCollections = [];

	$lang = isset($json->lang) && in_array($json->lang, ['de', 'en']) ? $json->lang : 'en';

	if($json->continent === 'tyria'){
		$featureCollections = [
			'explorables' => new GeoJSONFeatureCollection,
			'missions'    => new GeoJSONFeatureCollection,
			'outposts'    => new GeoJSONFeatureCollection,
			'bosses'      => new GeoJSONFeatureCollection,
			'labels'      => new GeoJSONFeatureCollection,
		];

		$db->select
			->cols(['id' => ['exp.explorable_id'], 'rect' => ['exp.rect'], 'name' => ['exp.name_'.$lang]])
			->from(['exp' => 'gw1_explorable', 'reg' => 'gw1_regions', 'con' => 'gw1_continents'])
			->where('exp.rect', '[[0,0],[0,0]]', '!=')
			->where('exp.region_id', 'reg.region_id', '=', false)
			->where('con.shortname', 'tyria')
			->where('reg.continent_id', 'con.continent_id', '=', false)
			->query()
			->__each(function(ResultRow $r) use (&$featureCollections){
				$p = [
					'name' => $r->name,
					'type' => 'explorable',
				];

				$rect = new GWContinentRect(json_decode($r->rect));

				$featureCollections['explorables']->addFeature((new GeoJSONFeature($rect->getPoly(), 'Polygon', $r->id))->setProperties($p));
				$featureCollections['labels']->addFeature((new GeoJSONFeature($rect->getCenter(), 'Point', $r->id))->setProperties($p));
			});

		$db->select
			->cols(['id' => ['mis.mission_id'], 'rect' => ['mis.rect'], 'name' => ['mis.name_'.$lang]])
			->from(['mis' => 'gw1_missions', 'reg' => 'gw1_regions', 'con' => 'gw1_continents'])
			->where('mis.rect', '[[0,0],[0,0]]', '!=')
			->where('mis.region_id', 'reg.region_id', '=', false)
			->where('con.shortname', 'tyria')
			->where('reg.continent_id', 'con.continent_id', '=', false)
			->query()
			->__each(function(ResultRow $r) use (&$featureCollections){
				$p = [
					'name' => $r->name,
					'type' => 'mission',
				];

				$rect = new GWContinentRect(json_decode($r->rect));

				$featureCollections['missions']->addFeature((new GeoJSONFeature($rect->getPoly(), 'Polygon', $r->id))->setProperties($p));
				$featureCollections['labels']->addFeature((new GeoJSONFeature($rect->getCenter(), 'Point', $r->id))->setProperties($p));
			});

		$db->select
			->cols(['id' => ['out.outpost_id'], 'coord' => ['out.coord'], 'rect' => ['out.rect'], 'name' => ['out.name_'.$lang], 'otype' => ['out.outposttype_id']])
			->from(['out' => 'gw1_outposts', 'reg' => 'gw1_regions', 'con' => 'gw1_continents'])
			->where('out.visible', 1)
			->where('out.outposttype_id', [1,2,3,4], 'in')
			->where('out.region_id', 'reg.region_id', '=', false)
			->where('con.shortname', 'tyria')
			->where('reg.continent_id', 'con.continent_id', '=', false)
			->orderBy(['out.outposttype_id' => 'DESC'])
			->query()
			->__each(function(ResultRow $r) use (&$featureCollections){
				$p = [
					'name'        => $r->name,
					'outposttype' => $r->otype,
					'type'        => 'outpost',
				];

				// @todo: outpost rect
				$point = json_decode($r->coord);
				$featureCollections['outposts']->addFeature((new GeoJSONFeature($point, 'Point', $r->id))->setProperties($p));

				$p['type'] = 'outpostLabel';
				$featureCollections['labels']->addFeature((new GeoJSONFeature($point, 'Point', $r->id))->setProperties($p));
			});

		$db->select
			->cols(['id' => ['boss.boss_id'], 'prof' => ['boss.profession'], 'skill' => ['boss.elite'], 'coord' => ['boss.coord'], 'name' => ['boss.name_'.$lang]])
			->from(['boss' => 'gw1_bosses', 'reg' => 'gw1_regions', 'con' => 'gw1_continents'])
			->where('con.shortname', 'tyria')
			->where('boss.region_id', [2,4,5,6,7,8,18,19,20], 'in')
			->where('boss.region_id', 'reg.region_id', '=', false)
			->where('reg.continent_id', 'con.continent_id', '=', false)
			->query()
			->__each(function(ResultRow $r) use (&$featureCollections){
				$p = [
					'name'  => $r->name,
					'prof'  => $r->prof,
					'skill' => $r->skill,
					'type'  => 'boss',
				];

				$featureCollections['bosses']->addFeature((new GeoJSONFeature(json_decode($r->coord), 'Point', $r->id))->setProperties($p)) ;
			});

		$featureCollections = array_map(function(GeoJSONFeatureCollection $featureCollection){
			return $featureCollection->toArray();
		}, $featureCollections);
	}

	// todo: dump the data to a static file
#	file_put_contents(__DIR__.'/gwdb/json/'.$json->continent.'.json', json_encode($featureCollections));

	send_json_response($featureCollections);
}
// Pokémon exception handler
catch(\Exception $e){
	header('HTTP/1.1 500 Internal Server Error');
	send_json_response(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
}

