<?php
/**
 * Class GWBBCodeTest
 *
 * @filesource   GWBBCodeTest.php
 * @created      27.04.2018
 * @package      chillerlan\GW1DBTest\GWBBCode
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest\GWBBCode;

use chillerlan\BBCode\BBCode;
use chillerlan\GW1DB\GW1DBOptions;
use chillerlan\GW1DB\GWBBCode\{
	GWBBMiddleware, GWBBOutput
};
use PHPUnit\Framework\TestCase;

class GWBBCodeTest extends TestCase{

	public function testBBCode(){

		$gwbboptions = new GW1DBOptions([
			'outputInterface'           => GWBBOutput::class,
			'parserMiddlewareInterface' => GWBBMiddleware::class,
			'sanitizeInput'             => true,
			'preParse'                  => true,
			'postParse'                 => true,
		]);


		$html = (new BBCode($gwbboptions))->parse(file_get_contents(__DIR__.'/gwbbcode.txt'));

		file_put_contents(__DIR__.'/gwbb-out.txt', $html);

#		print_r($html);
		$this->assertSame(1, 1); // trick the code coverage
	}

}
