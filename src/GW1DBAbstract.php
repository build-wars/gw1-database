<?php
/**
 * Class GW1DBAbstract
 *
 * @filesource   GW1DBAbstract.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB;

use chillerlan\Traits\ContainerInterface;

abstract class GW1DBAbstract implements GW1DataInterface{

	protected $options;

	public function __construct(ContainerInterface $options){
		$this->options = $options;
	}

}
