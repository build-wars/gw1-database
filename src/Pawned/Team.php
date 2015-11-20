<?php
/**
 *
 * @filesource   Team.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Pawned
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Pawned;

use chillerlan\GW1Database\Template\SetBase;

/**
 * Class Team
 */
class Team extends SetBase{

	/**
	 * @var string
	 */
	public $pawned_prefix = 'pwnd0000';

	/**
	 * @var string
	 */
#	public $pawned_header = '?download paw·ned² @ www.gwcom.de Copyright numma_cway aka Redeemer';
	public $pawned_header;

	/**
	 * @var array
	 */
	public $players = [];

}
