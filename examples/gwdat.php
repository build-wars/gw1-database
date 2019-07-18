<?php
/**
 * @filesource   gwdat.php
 * @created      03.07.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBExamples;

use chillerlan\GW1DB\GWDatReader;

require_once __DIR__.'/../vendor/autoload.php';

$reader = new GWDatReader('D:\Games\GUILD WARS');

$reader->read();
