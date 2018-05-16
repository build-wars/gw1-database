<?php
/**
 * Class Item
 *
 * @filesource   Item.php
 * @created      15.05.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\GW1DB\Data\GWItemDB;
use chillerlan\GW1DB\Data\GWModDB;

class Item extends TemplateAbstract{

	protected $id;
	protected $slot; // 0. Weapon, 1. Off-hand, 2. Chest, 3. Legs, 4. Head, 5. Feet, 6. Hands
	protected $color; // 2. Blue, 3. Green, 4. Purple, 5. Red, 6. Yellow, 7. Brown, 8. Orange, 9. Grey

	protected $data;

	protected $prefix;
	protected $suffix;
	protected $inscription;

	/**
	 * Item constructor.
	 *
	 * @param int         $itemID
	 * @param int         $slot
	 * @param int         $color
	 * @param string|null $defaultLang
	 */
	public function __construct(int $itemID, int $slot, int $color, string $defaultLang = null){
		$this->id    = $itemID;
		$this->slot  = $slot;
		$this->color = $color;

		$this->data = GWItemDB::id2item[$this->id] ?? null;

		if($defaultLang = null){
			$this->defaultLang = $defaultLang;
		}

		$this->lang = $this->defaultLang;
	}

	/**
	 * @param array $mods
	 *
	 * @return \chillerlan\GW1DB\Template\Item
	 */
	public function setMods(array $mods):Item{

		foreach($mods as $id){

			if(!array_key_exists($id, GWModDB::id2mod)){
				continue;
			}

			$mod = GWModDB::id2mod[$id];

			switch($mod['type']){
				case 0:
				case 4:
					$this->prefix = $mod;
					break;
				case 1:
				case 2:
				case 3:
				case 5:
					$this->suffix = $mod;
					break;
				case 6:
					$this->inscription = $mod;
					break;
			}

		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function toHTML():string{

		if(!$this->data){
			return '';
		}

		// @todo
		$prefix_conn = ['de' => '-', 'en' => ' '][$this->lang];
		$suffix_conn = ['de' => ' d. ', 'en' => ' of '][$this->lang];

		$prefix = isset($this->prefix['ext']) ? $this->prefix['ext'][$this->lang].$prefix_conn : '';
		$suffix = isset($this->suffix['ext']) ? $suffix_conn.$this->suffix['ext'][$this->lang] : '';

		return $prefix.$this->data['name'][$this->lang].$suffix.'<br/>';
	}

}
