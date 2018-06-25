<?php
/**
 * Class GeoJSONFeatureCollection
 *
 * @link https://tools.ietf.org/html/rfc7946
 *
 * @filesource   GeoJSONFeatureCollection.php
 * @created      25.06.2018
 * @package      chillerlan\GW1DB\Maps
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Maps;

class GeoJSONFeatureCollection{

	/**
	 * @var array
	 */
	protected $features = [];

	/**
	 * @var array
	 */
	protected $bbox;

	/**
	 * GeoJSONFeatureCollection constructor.
	 *
	 * @param \chillerlan\GW1DB\Maps\GeoJSONFeature[]|null $features
	 */
	public function __construct(array $features = null){

		if(!empty($features)){
			$this->addFeatures($features);
		}

	}

	/**
	 * @param array $bbox
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeatureCollection
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function setBbox(array $bbox):GeoJSONFeatureCollection{

		if(!in_array(count($bbox), [4, 6], true)){
			throw new GeoJSONException('invalid bounding box array');
		}

		$this->bbox = $bbox;

		return $this;
	}

	/**
	 * @param \chillerlan\GW1DB\Maps\GeoJSONFeature $feature
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeatureCollection
	 */
	public function addFeature(GeoJSONFeature $feature):GeoJSONFeatureCollection{
		$this->features[] = $feature;

		return $this;
	}

	/**
	 * @param array $features
	 *
	 * @return $this
	 */
	public function addFeatures(array $features):GeoJSONFeatureCollection{

		foreach($features as $feature){
			if($feature instanceof GeoJSONFeature){
				$this->addFeature($feature);
			}
		}

		return $this;
	}

	/**
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeatureCollection
	 */
	public function clearFeatures():GeoJSONFeatureCollection{
		$this->features = [];

		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray():array{
		$arr = ['type' => 'FeatureCollection'];

		if(!empty($this->bbox)){
			$arr['bbox'] = $this->bbox;
		}

		$arr['features'] = array_map(function(GeoJSONFeature $feature){
			return $feature->toArray();
		}, $this->features);

		return $arr;
	}

	/**
	 * @param int|null $options
	 *
	 * @return string
	 */
	public function toJSON(int $options = null):string{
		return json_encode($this->toArray(), $options ?? 0);
	}

}
