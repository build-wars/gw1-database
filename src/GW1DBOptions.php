<?php
/**
 * Class GW1DBOptions
 *
 * @filesource   GW1DBOptions.php
 * @created      16.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB;

use chillerlan\BBCode\BBCodeOptionsTrait;
use chillerlan\Database\DatabaseOptionsTrait;
use chillerlan\Traits\ContainerAbstract;

/**
 * @property string $language
 * @property string $gwdbURL
 */
class GW1DBOptions extends ContainerAbstract{
	use GW1DBOptionsTrait, DatabaseOptionsTrait, BBCodeOptionsTrait;
}
