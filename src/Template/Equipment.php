<?php
/**
 * Class Equipment
 *
 * @filesource   Equipment.php
 * @created      02.05.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

class Equipment extends BuildAbstract{

	protected $items = [];

	public function toHTML():string{

		$html = [];

		foreach($this->items as $item){

			if($item instanceof Item){
				$html[] = $item->toHTML();
			}

		}


		return implode(PHP_EOL, $html);
	}

	/**
	 * @link https://wiki.guildwars.com/wiki/Equipment_template_format
	 *
	 * @param string $template
	 *
	 * @return \chillerlan\GW1DB\Template\BuildInterface|null
	 */
	public function decode(string $template):?BuildInterface {
		$bin = $this->tpl_decode($template);

		if(!in_array($this->template_type, [1, 15], true)){
			// invalid equipment template type
			return null;
		}

		// get item length code, mod length code and item count
		if(!preg_match('/^(?P<iteml>[01]{4})(?P<modl>[01]{4})(?P<itemc>[01]{3})/', $bin, $info)){
			// invalid equipment template
			return null;
		}

		// cut 4+4+3 bits
		$bin = substr($bin, 11);

		$item_count  = $this->bindec_flip($info['itemc']);
		$item_length = $this->bindec_flip($info['iteml']);
		$mod_length  = $this->bindec_flip($info['modl']);


		// loop through the items
		for($i = 0;  $i < $item_count; $i++){

			// get item type, id, number of mods and item color
			if(!preg_match('/^(?P<slot>[01]{3})(?P<id>[01]{'.$item_length.'})(?P<modc>[01]{2})(?P<color>[01]{4})/', $bin, $item)){
				// invalid equipment item
				return null;
			}

			$mods = [];
			$bin = substr($bin, $item_length + 9);

			$this->items[$i] = (new Item(
					$this->bindec_flip($item['id']),
					$this->bindec_flip($item['slot']),
					$this->bindec_flip($item['color']),
					$this->lang
				));

			// loop through the mods
			for($j = 0, $mod_count = $this->bindec_flip($item['modc']); $j < $mod_count; $j++){
				$mods[$j] = $this->bindec_flip(substr($bin, 0, $mod_length));
				$bin = substr($bin, $mod_length);
			}

			$this->items[$i]->setMods($mods);
		}

		$this->code = $template;


		return $this;
	}

	/**
	 * @return string
	 */
	public function encode():?string{
		// start of the binary string: type (15,4), version (0,4)
/*		$bin  = $this->decbin_pad($build['type'], 4);
		$bin .= '0000';

		$item_count  = count($build['items']);
		$item_length = 1;
		$mod_length  = 1;

		if($item_count > 0){
			// get item length code
			$item_length = max(array_column($build['items'], 'id')) > 255 ? 9 : 8;

			// get mod length code
			$max = [];
			foreach($build['items'] as $d){
				$max = array_merge($max, $d['mods']);
			}

			$mod_length = max($max) > 255 ? 9 : 8;
		}

		// add length codes and item count
		$bin .= $this->decbin_pad($item_length, 4);
		$bin .= $this->decbin_pad($mod_length, 4);
		$bin .= $this->decbin_pad($item_count, 3);

		// add items
		foreach($build['items'] as $d){
			$bin .= $this->decbin_pad($d['type'], 3);
			$bin .= $this->decbin_pad($d['id'], $item_length);
			$bin .= $this->decbin_pad(count($d['mods']), 2);
			$bin .= $this->decbin_pad($d['color'], 4);

			// add mods for current item
			foreach($d['mods'] as $mod){
				$bin .= $this->decbin_pad($mod, $mod_length);
			}
		}

		return $this->tpl_encode($bin);
*/
		return '';
	}



}
