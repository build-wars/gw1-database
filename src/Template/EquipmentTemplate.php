<?php
/**
 * Class EquipmentTemplate
 *
 * @filesource   EquipmentTemplate.php
 * @created      12.04.2018
 * @package      chillerlan\GW1DB
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

/**
 */
class EquipmentTemplate extends TemplateAbstract{

	protected $type = 15;

	/**
	 * @param string $template
	 *
	 * @return array|\chillerlan\Traits\ContainerInterface
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function decode(string $template):array {
		$bin = $this->tpl_decode($template);

		if(!in_array($this->type, [1, 15], true)){
			throw new TemplateException('invalid equipment template type ('.$this->type.')');
		}

		// get item length code, mod length code and item count
		if(!preg_match('/^(?P<iteml>[01]{4})(?P<modl>[01]{4})(?P<itemc>[01]{3})/', $bin, $info)){
			throw new TemplateException('invalid equipment template');
		}

		// cut 4+4+3 bits
		$bin = substr($bin, 11);

		$item_count  = $this->bindec_flip($info['itemc']);
		$item_length = $this->bindec_flip($info['iteml']);
		$mod_length  = $this->bindec_flip($info['modl']);

		$data = [
			'type'  => $this->type,
			'code'  => $template,
			'items' => [],
		];

		// loop through the items
		for($i = 0;  $i < $item_count; $i++){

			// get item type, id, number of mods and item color
			if(!preg_match('/^(?P<type>[01]{3})(?P<id>[01]{'.$item_length.'})(?P<modc>[01]{2})(?P<color>[01]{4})/', $bin, $item)){
				throw new TemplateException('invalid equipment item');
			}

			$bin = substr($bin, 9+$item_length);

			// push the data to the output array
			$data['items'][$i] = [
				'id'    => $this->bindec_flip($item['id']),
				'type'  => $this->bindec_flip($item['type']),
				'color' => $this->bindec_flip($item['color']),
				'mods'  => []
			];

			// loop through the mods
			for($j = 0, $mod_count = $this->bindec_flip($item['modc']); $j < $mod_count; $j++){
				$data['items'][$i]['mods'][$j] = $this->bindec_flip(substr($bin, 0, $mod_length));
				$bin = substr($bin, $mod_length);
			}
		}

		return $data;
	}

	/**
	 * @param array $build
	 *
	 * @return string
	 */
	public function encode(array $build):string{
		// start of the binary string: type (15,4), version (0,4)
		$bin  = $this->decbin_pad($build['type'], 4);
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
	}

}
