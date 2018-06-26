<?php
/**
 * Class GeoJSONFeature
 *
 * @link https://tools.ietf.org/html/rfc7946
 *
 * @filesource   GeoJSONFeature.php
 * @created      25.06.2018
 * @package      chillerlan\GW1DB\Maps
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Maps;

class GeoJSONFeature{

	public const types = [
		'Point',
		'MultiPoint',
		'LineString',
		'MultiLineString',
		'Polygon',
		'MultiPolygon',
		'GeometryCollection',
	];

	/**
	 * @var array
	 */
	protected $coords;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $properties;

	/**
	 * @var int|string
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $bbox;

	/**
	 * GeoJSONFeature constructor.
	 *
	 * @param array|null  $coords
	 * @param string|null $type
	 * @param int|null    $id
	 *
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function __construct(array $coords = null, string $type = null, $id = null){

		if($coords !== null){

			if($type === null){
				throw new GeoJSONException('got coords but no feature type');
			}

			$this->setGeometry($coords, $type);
		}

		if($id !== null){
			$this->setID($id);
		}

	}

	/**
	 * @param array  $coords
	 * @param string $type
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeature
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function setGeometry(array $coords, string $type):GeoJSONFeature{

		if(empty($coords)){
			throw new GeoJSONException('invalid coords array');
		}

		if(!in_array($type, $this::types, true)){
			throw new GeoJSONException('invalid geometry type');
		}

		$this->coords = $coords;
		$this->type   = $type;

		return $this;
	}

	/**
	 * @param array $properties
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeature
	 */
	public function setProperties(array $properties):GeoJSONFeature{
		$this->properties = $properties;

		return $this;
	}

	/**
	 * @param int|string $id
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeature
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function setID($id):GeoJSONFeature{

		if(empty($id) || (!is_string($id) && !is_numeric($id))){
			throw new GeoJSONException('invalid id');
		}

		$this->id = $id;

		return $this;
	}

	/**
	 * @param array $bbox
	 *
	 * @return \chillerlan\GW1DB\Maps\GeoJSONFeature
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function setBbox(array $bbox):GeoJSONFeature{

		if(!in_array(count($bbox), [4, 6], true)){
			throw new GeoJSONException('invalid bounding box array');
		}

		$this->bbox = $bbox;

		return $this;
	}

	/**
	 * @return array
	 * @throws \chillerlan\GW1DB\Maps\GeoJSONException
	 */
	public function toArray():array{
		$arr = ['type' => 'Feature'];

		if(empty($this->coords) || empty($this->type)){
			throw new GeoJSONException('invalid feature');
		}

		$arr['geometry'] = [
			'type'        => $this->type,
			'coordinates' => $this->coords,
		];

		if(!empty($this->bbox)){
			$arr['bbox'] = $this->bbox;
		}

		if(!empty($this->properties)){
			$arr['properties'] = $this->properties;
		}

		if(!empty($this->id)){
			// serving both, leaflet and GMaps...
			$arr['properties']['id'] = $this->id;
#			$arr['id'] = $this->id;
		}

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
