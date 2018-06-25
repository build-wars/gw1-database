<?php
/**
 * Class GWContinentRect
 *
 * @filesource   GWContinentRect.php
 * @created      25.06.2018
 * @package      chillerlan\GW1DB\Maps
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Maps;

class GWContinentRect{

	/**
	 * @var array
	 */
	protected $rect;

	/**
	 * GWContinentRect constructor.
	 *
	 * @param array $continent_rect (NW/SE corners [[nw_x, nw_y],[se_x, se_y]])
	 */
	public function __construct(array $continent_rect){
		$this->rect = $continent_rect;
	}

	/**
	 * returns bounds for L.LatLngBounds() (NE/SW corners)
	 *
	 * @return array
	 */
	public function getBounds(){
		return [
			[$this->rect[0][0], $this->rect[1][1]],
			[$this->rect[1][0], $this->rect[0][1]],
		];
	}

	/**
	 * returns the center of the rectangle
	 *
	 * @return array
	 */
	public function getCenter(){
		return [
			($this->rect[0][0] + $this->rect[1][0]) / 2,
			($this->rect[0][1] + $this->rect[1][1]) / 2,
		];
	}

	/**
	 * returns a polygon made of the rectangles corners
	 *
	 * @return array
	 */
	public function getPoly(){
		return [[
			[$this->rect[0][0], $this->rect[0][1]],
			[$this->rect[1][0], $this->rect[0][1]],
			[$this->rect[1][0], $this->rect[1][1]],
			[$this->rect[0][0], $this->rect[1][1]]
		]];
	}

}
