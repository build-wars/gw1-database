<?php
/**
 * Class SkillTemplateTest
 *
 * @filesource   SkillTemplateTest.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DBTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest\Template;

use chillerlan\GW1DB\Template\SkillTemplate;

class SkillTemplateTest extends TemplateTestAbstract{

	public function testStuff(){
		$templateInterface   = new SkillTemplate;
		$tpl = 'OQdCA8wkpTeGbji4b2PwDAPF';

		// @todo: fix output template code (order, header?)
		$this->assertSame('OQdSA4BTmO5ZsNKivZ/APA8UA', $templateInterface->encode($templateInterface->decode($tpl)));
	}
}
