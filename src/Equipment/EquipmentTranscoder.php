<?php
/**
 * Class EquipmentTranscoder
 *
 * @filesource   EquipmentTranscoder.php
 * @created      05.11.2015
 * @package      chillerlan\GW1Database\Equipment
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Equipment;

use chillerlan\GW1Database\GW1DatabaseException;
use chillerlan\GW1Database\Template\Transcoder;
use chillerlan\GW1Database\Equipment\Item;
use chillerlan\GW1Database\Equipment\Set;

/**
 *
 */
class EquipmentTranscoder extends Transcoder{

	/**
	 * @var \chillerlan\GW1Database\Equipment\Set
	 */
	protected $template;

	/**
	 * EquipmentTranscoder constructor.
	 *
	 * @param \chillerlan\GW1Database\Equipment\Set $template [optional]
	 */
	public function __construct(Set $template = null){
		if($template instanceof Set){
			$this->template = $template;
		}
	}

	/**
	 * @return \chillerlan\GW1Database\Equipment\Set
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function get_template(){
		if(!$this->template instanceof Set){
			throw new GW1DatabaseException('Invalid equipment template!');
		}

		return $this->template;
	}

	/**
	 * @param \chillerlan\GW1Database\Equipment\Set $template
	 *
	 * @return $this
	 */
	public function set_template(Set $template){
		$this->template = $template;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function decode(){
		$bin = $this->template_decode($this->template->code);

		if(!$bin){
			return $this;
		}

		// get item length code, mod length code and item count
		if(!preg_match('/^(?<iteml>[01]{4})(?<modl>[01]{4})(?<itemc>[01]{3})/', $bin, $info)){
			// possibly invalid
			return $this;
		}

		$bin = substr($bin, 11);

		$item_length = $this->bindec_flip($info['iteml']);
		$mod_length = $this->bindec_flip($info['modl']);

		// loop through the items
		for($i = 0, $item_count = $this->bindec_flip($info['itemc']); $i < $item_count; $i++){
			// get item type, id, number of mods and item color
			if(!preg_match('/^(?<type>[01]{3})(?<id>[01]{'.$item_length.'})(?<modc>[01]{2})(?<color>[01]{4})/', $bin, $item)){
				return $this;
			}

			$bin = substr($bin, 9+$item_length);

			$id = $this->bindec_flip($item['id']);

			$eq_item = new Item;
			$eq_item->color = $this->bindec_flip($item['color']);
			$eq_item->id = $id;
			$eq_item->type = $this->bindec_flip($item['type']);

			// loop through the mods
			for($j = 0, $mod_count = $this->bindec_flip($item['modc']); $j < $mod_count; $j++){
				$eq_item->mods[] = $this->bindec_flip(substr($bin, 0, $mod_length));
				$bin = substr($bin, $mod_length);
			}

			// push the data to the output array
			$this->template->items[$id] = $eq_item;

		}

		$this->template->decode_valid = true;

		return $this;
	}

	/**
	 * @return $this
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function encode(){
		if(!$this->template instanceof Set){
			throw new GW1DatabaseException('Invalid equipment template!');
		}

		// start of the binary string: type (15,4), version (0,4)
		$bin = '11110000';

		$item_count = count($this->template->items);

		if($item_count > 0){
			// get item length code
			$item_length = max(array_keys($this->template->items)) > 255 ? 9 : 8;

			// get mod length code
			$max = [];
			foreach($this->template->items as $item){
				$max = array_merge($max, $item->mods);
			}
			$mod_length = max($max) > 255 ? 9 : 8;
		}
		else{
			$item_length = 1;
			$mod_length = 1;
		}

		// add length codes and item count
		$bin .= $this->decbin_pad($item_length, 4);
		$bin .= $this->decbin_pad($mod_length, 4);
		$bin .= $this->decbin_pad($item_count, 3);

		// add items
		foreach($this->template->items as $id => $item){
			$bin .= $this->decbin_pad($item->type, 3);
			$bin .= $this->decbin_pad($id, $item_length);
			$bin .= $this->decbin_pad(count($item->mods), 2);
			$bin .= $this->decbin_pad($item->color, 4);
			// add mods for current item
			foreach($item->mods as $mod){
				$bin .= $this->decbin_pad($mod, $mod_length);
			}
		}

		$this->template->code_out = $this->template_encode($bin);
		$this->template->encode_valid = (bool)$this->template->code_out;

		return $this;
	}

}
