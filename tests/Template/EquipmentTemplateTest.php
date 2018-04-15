<?php
/**
 * Class EquipmentTemplateTest
 *
 * @filesource   EquipmentTemplateTest.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DBTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest\Template;

use chillerlan\GW1DB\Template\EquipmentTemplate;

class EquipmentTemplateTest extends TemplateTestAbstract{

	public function testDecodeEncode(){
		$templateInterface = new EquipmentTemplate;

		$tpl = 'Pg5hhmZ9phOzriUhhpI904yUkhl/YKyl0BMFZYNLmi0C';

		$this->assertSame($tpl, $templateInterface->encode($templateInterface->decode($tpl)));
	}

}
