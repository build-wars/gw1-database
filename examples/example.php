<?php
/**
 * @filesource   example.php
 * @created      06.11.2015
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

require_once '../vendor/autoload.php';

use chillerlan\GW1Database\Equipment\Set;
use chillerlan\GW1Database\Equipment\EquipmentTranscoder;
use chillerlan\GW1Database\Pawned\Team;
use chillerlan\GW1Database\Pawned\PawnedTranscoder;
use chillerlan\GW1Database\Skills\Build;
use chillerlan\GW1Database\Skills\SkillTranscoder;

// skill template
$st = new SkillTranscoder;
$skills = new Build('OQdCA8wkpTeGbji4b2PwDAPF');

$skills = $st->set_template($skills)->decode()->get_template();
var_dump($skills);

$skills = $st->encode()->get_template();
var_dump($skills);



// equipment template
$et = new EquipmentTranscoder;
$equipment = new Set('Pg5hhmZ9phOzriUhhpI904yUkhl/YKyl0BMFZYNLmi0C');

$equipment = $et->set_template($equipment)->decode()->get_template();
var_dump($equipment);

$equipment = $et->encode()->get_template();
var_dump($equipment);



// paw·ned² template
$pt = new PawnedTranscoder;
$pwnd = new Team('pwnd0000?download paw·ned² @ www.gw-tactics.de Copyright numma_cway aka Redeemer
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
AA0RW1vCmRvd25sb2FkZWQgZnJvbSBodHRwOi8vd3d3Lmd3Y29tLmRl<');

$pwnd = $pt->set_template($pwnd)->decode()->get_template();
var_dump($pwnd);

$pwnd = $pt->encode()->get_template();
var_dump($pwnd);
