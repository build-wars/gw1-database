<?php
/**
 * Class PwndTemplateTest
 *
 * @filesource   PwndTemplateTest.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DBTest\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBTest\Template;

use chillerlan\GW1DB\Template\PwndTemplate;

class PwndTemplateTest extends TemplateTestAbstract{

	public function testStuff(){
		$templateInterface = new PwndTemplate;

		$tpl = 'pwnd0000?PwndTemplate https://github.com/codemasher/gw1-database	
>YOwVS85BTRA6M4OIQ0kHQxldOsPk5JWEMZYE8EMJYd8EMJYn8EMJY77EMJYRRFSaCjkC0KJPcZQcTKl
UAACAgAA2VGFuawpkb3dubG9hZGVkIGZyb20gaHR0cDovL3d3dy5nd2NvbS5kZQZOQZDAswzQqDuNmOT
P2kBBiOwloPgp5PCjcJCXhRCWnrwItw0VYkgt3KMSwiJHsIb+KPPgpghmZ9phOzriUQPkpQRNNYSjkM3
6SBACIhAA4Q2FsbGVyCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmRlYOQdCAsw0SwJgp
z0TMpcZnDcJoPgp5PCjcJCXhRCWnrwItw0VYkgt3KMSwiJHsIb+KPPgpghmZ9phOzriUQPkpQRNNYSjk
M36SBJPcZQcTKlUCIgAA4UmVjYWxsCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmRlaOQ
JTAQBbVaJ4Ew0Z6RGA6gDAuEoPgp5PCjcJCXhRCWnrwItw0VYkgt3KMyMgJHsIb+KPPgpghmZ9phOzri
UQPkpQRNNYSjkM36SBACIgAA4RW9FL0JGCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmR
lZOQRDAsw3QLBnAmOTP0k3gaAwloPgp5PCjcJCXhRCWnrwItw0VYkgt3KMSwiJHsIb+KPPgpghmZ9phO
zriUQPkpQRNNYSjkM36SBACIgAA3U3BsaXQKZG93bmxvYWRlZCBmcm9tIGh0dHA6Ly93d3cuZ3djb20u
ZGUZOQNDAsw/QLBnAmOTPxkCObAwloPgp5PCjcJCXhRCWnrwItw0VYkgt3KMSwiJHsIb+KPPgpghmZ9p
hOzriUQPkpQRNNYSjkM36SBACIgAAzVUEKZG93bmxvYWRlZCBmcm9tIGh0dHA6Ly93d3cuZ3djb20uZG
UaOwIT8QIjVC5IHMlghgukeIeAgAoPgpJTCiULCbBR6JntgID70WQkhtXLIywCOHsIbsEQPkpQRNNYSj
kM36SBAACAkAA4U2VlZGVyCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmRlYOgNDwcPPP
aRSyNrWQLkHxjDCpPkpZSEEpUE1EEpnc1EEZYn1EEZY70EEZYxTHsIbsEQPkpQRNNYSjkM36SBAADAAg
AA0RW1vCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmRl<';

		$this->assertSame($tpl, $templateInterface->encode($templateInterface->decode($tpl)));
	}

}
