<?php
/**
 * Class GWBBcode
 *
 * @filesource   GWBBcode.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\bbcode\Html5
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\bbcode\Html5;

use chillerlan\bbcode\Modules\ModuleInterface;
use chillerlan\GW1Database\bbcode\Html5\GWBBHtml5BaseModule;

/**
 *
 */
class GWBBcode extends GWBBHtml5BaseModule implements ModuleInterface{

	/**
	 * An array of tags the module is able to process
	 *
	 * @var array
	 * @see \chillerlan\bbcode\Modules\Tagmap::$tags
	 */
	protected $tags = ['build', 'equipment', 'pwnd', 'skill'];


	/**
	 * Transforms the bbcode, called from BaseModuleInterface
	 *
	 * Any match will be replaced with a substitute which then will be replaced with the actual HTML by the post-parser.
	 *
	 * @return string a transformed snippet
	 * @see \chillerlan\bbcode\Modules\BaseModuleInterface::transform()
	 * @internal
	 */
	public function _transform(){
		if($this->tag === 'build'){
			$bbtag = $this->bbtag();
			if($bbtag && empty($this->content)){
				return '{BUILDCODE|'.implode('|', explode(';', $bbtag)).'}';
			}

			if(preg_match_all('/\[(?<skill>[^\]]+)\]/', $this->eol($this->content), $matches, PREG_SET_ORDER) > 0){
				// todo: name, desc, pvp, attributes & professions
#				var_dump($this->attributes);

				return '{BUILD|'.'#'.'#'.implode('|', array_column($matches, 'skill')).'}';
			}
		}
		else if($this->tag === 'skill'){
			return '{SKILL|'.$this->content.'|'.intval($this->get_attribute('image')).'|'.$this->bbtag(0).'}';
		}
		else if($this->tag === 'equipment'){

		}
		else if($this->tag === 'pwnd'){
			// todo: create pwnd builds from skillnames
			if(preg_match('#(?<pwnd>\>[a-z/\d\+\s]+\<)#i', htmlspecialchars_decode($this->eol($this->content)), $match)){
				return '{PWND|'.$match['pwnd'].'}';
			}
		}

		return '';
	}

}
