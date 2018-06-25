<?php
/**
 * Class GWContinentRectTest
 *
 * @filesource   GWContinentRectTest.php
 * @created      25.06.2018
 * @package      chillerlan\GW1DBTest\Maps
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest\Maps;

use chillerlan\GW1DB\Maps\GWContinentRect;
use PHPUnit\Framework\TestCase;

class GWContinentRectTest extends TestCase{

	/**
	 * @var \chillerlan\GW1DB\Maps\GWContinentRect
	 */
	protected $rect;

	protected function setUp(){
		$this->rect = new GWContinentRect([[0, 0], [1024, 512]]);
	}

	public function testGetBounds(){
		$this->assertSame([[0, 512],[1024, 0]], $this->rect->getBounds());
	}

	public function testGetCenter(){
		$this->assertSame([512, 256], $this->rect->getCenter());
	}

	public function testGetPoly(){
		$this->assertSame([[[0, 0], [1024, 0], [1024, 512], [0, 512]]], $this->rect->getPoly());
	}

}
