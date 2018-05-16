<?php
/**
 * Interface BuildInterface
 *
 * @filesource   BuildInterface.php
 * @created      14.05.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

interface BuildInterface{
	public function setName(string $name):BuildInterface;
	public function setDescription(string $desc):BuildInterface;
	public function decode(string $template):?BuildInterface;
	public function encode():?string;
}
