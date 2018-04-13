<?php
/**
 *
 * @filesource   TemplateInterface.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\Traits\ContainerInterface;

/**
 * Interface TemplateInterface
 */
interface TemplateInterface{

	/**
	 * @param string $template
	 *
	 * @return array
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function decode(string $template):array;

	/**
	 * @param array $build
	 *
	 * @return string
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function encode(array $build):string;

}
