<?php
/**
 * Class Pwnd
 *
 * @filesource   Pwnd.php
 * @created      30.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

class Pwnd extends BuildAbstract{

	protected $pwnd_header = '?pwnd-encoder https://github.com/codemasher/gw1-database';
	protected $players     = [];


	public function toHTML():string{

		$html = '<div class="gwbb-pwnd">';

		foreach($this->players as $i => $player){
			$html .=  $player instanceof Build ? $player->toHTML(true) : $player; // @todo
		}

		$html .= '</div>'.PHP_EOL;

		return $html;
	}

	/**
	 * @param string $pwnd
	 *
	 * @return \chillerlan\GW1DB\Template\BuildInterface|null
	 */
	public function decode(string $pwnd):?BuildInterface{
		$pwnd  = str_replace(["\r", "\n"], '', $pwnd);
		$start = strpos($pwnd, '>');
		$end   = strpos($pwnd, '<', $start) - 1;

		if($end > $start && $end !== 0){
			$header  = substr($pwnd, 0, $start);
			$content = substr($pwnd, $start + 1, $end - $start);

			if(substr($header, 0, 7) === 'pwnd000'){
				$offset = 0;
				$p = 0;

				while($offset < strlen($content)){
					$b = new Build($this->lang);

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;

					if(!$b->decode(substr($content, $offset, $length))){
						continue;
					}

					$offset += $length;
					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;

					$eq = (new Equipment($this->lang))->decode(substr($content, $offset, $length));

					if($eq instanceof Equipment){
						$b->setEquipment($eq);
					}

					$offset += $length;

					for($i = 0; $i < 3; $i++){
						$length = $this->base64_ord(substr($content, $offset, 1));
						$offset++;

						$w = (new Equipment($this->lang))->decode(substr($content, $offset, $length));

						if($w instanceof Equipment){
							$b->setWeaponset($i, $w);
						}

						$offset += $length;
					}

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;

					$build['flags'] = substr($content, $offset, $length);

					$offset += $length;
					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;

					$build['player'] = base64_decode(substr($content, $offset, $length));

					$offset += $length;
					$length = $this->base64_ord(substr($content, $offset, 1)) * 64;
					$offset++;
					$length += $this->base64_ord(substr($content, $offset, 1));
					$offset++;

					$desc = explode("\n", str_replace([ // @todo
						'downloaded from http://www.gwcom.de',
						'download paw·ned² @ www.gw-tactics.de Copyright numma_cway aka Redeemer',
						"\r"
					], '', base64_decode(substr($content, $offset, $length))));

					$b
						->setName($desc[0])
						->setDescription($desc[1] ?? '')
					;

					$offset += $length;

					$this->players[$p] = $b;
					$p++;
				}

				return $this;
			}

			// pawned-prefix not found
			return null;
		}

		// no content in between the >< brackets
		return null;
	}


	public function encode():?string{
		$pwnd = '';
/*
		foreach($build as $b){

			if(!isset($b['equipment'])){
				$b['equipment'] = '';
			}

			foreach(['description', 'equipment', 'skills'] as $key){
				$b[$key] = str_replace('=', '', $b[$key]);
			}

			$pwnd .= $this->base64_chr(strlen($b['skills']));
			$pwnd .= $b['skills'];

			$pwnd .= $this->base64_chr(strlen($b['equipment']));
			$pwnd .= $b['equipment'];

			for($i = 0; $i < 3; $i++){
				$b['weaponsets'][$i] = isset($b['weaponsets'][$i]) ? str_replace('=', '', $b['weaponsets'][$i]) : '';
				$pwnd .= $this->base64_chr(strlen($b['weaponsets'][$i]));
				$pwnd .= $b['weaponsets'][$i];
			}

			$pwnd .= $this->base64_chr(strlen($b['flags']));
			$pwnd .= $b['flags'];

			$pwnd .= $this->base64_chr(strlen($b['player']));
			$pwnd .= $b['player']; // base64_encode

			$pwnd .= $this->base64_chr(strlen($b['description']) / 64);
			$pwnd .= $this->base64_chr(strlen($b['description']) % 64);
			$pwnd .= $b['description']; // base64_encode
		}

		return 'pwnd0001'.$this->pwnd_header.PHP_EOL.trim(chunk_split('>'.$pwnd.'<', 80));
*/
		return $pwnd;
	}

}
