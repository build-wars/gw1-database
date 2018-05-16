<?php
/**
 * Interface TemplateInterface
 *
 * @filesource   TemplateInterface.php
 * @created      29.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

interface TemplateInterface{
	public function setProfessions(int $pri = null, int $sec = null):TemplateInterface;
	public function setAttributes(array $attributes):TemplateInterface;
	public function setPvP(bool $pvp):TemplateInterface;
	public function setLang(string $lang):TemplateInterface;
	public function toHTML():string;
}
