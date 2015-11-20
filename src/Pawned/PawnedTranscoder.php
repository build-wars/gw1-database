<?php
/**
 * Class PawnedTranscoder
 *
 * @filesource   PawnedTranscoder.php
 * @created      06.11.2015
 * @package      chillerlan\GW1Database\Pawned
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\Pawned;

use chillerlan\GW1Database\Equipment\Set;
use chillerlan\GW1Database\GW1DatabaseException;
use chillerlan\GW1Database\Skills\Build;
use chillerlan\GW1Database\Template\Transcoder;
use chillerlan\GW1Database\Pawned\Player;
use chillerlan\GW1Database\Pawned\Team;

/**
 *
 */
class PawnedTranscoder extends Transcoder{

	/**
	 * @var \chillerlan\GW1Database\Pawned\Team
	 */
	protected $template;

	private $content;
	private $offset;
	private $length;

	/**
	 * PawnedTranscoder constructor.
	 *
	 * @param \chillerlan\GW1Database\Pawned\Team $template [optional]
	 */
	public function __construct(Team $template = null){
		if($template instanceof Team){
			$this->template = $template;
		}
	}

	/**
	 * @return \chillerlan\GW1Database\Pawned\Team
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function get_template(){
		if(!$this->template instanceof Team){
			throw new GW1DatabaseException('Invalid paw·ned² template!');
		}

		return $this->template;
	}

	/**
	 * @param \chillerlan\GW1Database\Pawned\Team $template
	 *
	 * @return $this
	 */
	public function set_template(Team $template){
		$this->template = $template;

		return $this;
	}

	/**
	 * @return string
	 */
	private function _get_value(){
		$this->length = $this->base64_ord(substr($this->content, $this->offset, 1));
		$this->offset++;
		$value = substr($this->content, $this->offset, $this->length);
		$this->offset += $this->length;

		return $value;
	}

	/**
	 * @return $this
	 */
	public function decode(){
		$pwnd = $this->template->code;

		if(empty($pwnd)){
			return $this;
		}

		$pwnd = str_replace(["\r", "\n"], '', $pwnd);
		$start = strpos($pwnd, '>');
		$end = strpos($pwnd, '<', $start) - 1;

		if($start && $end && $end > $start){
			$header = substr($pwnd, 0, $start);
			$this->content = substr($pwnd, $start + 1, $end - $start);

			if(substr($header, 0, 8) === $this->template->pawned_prefix){
				$this->template->pawned_header = substr($header, 8);

				$this->offset = 0;
				while($this->offset < strlen($this->content)){
					$player = new Player;
					$player->skills = new Build($this->_get_value());
					$player->equipment = new Set($this->_get_value());

					foreach(range(2, 4) as $i){ // weaponsets 1-based, first set is in equipment
						$player->weaponsets[$i] = new Set($this->_get_value());
					}

					$player->flags = $this->_get_value();
					$player->name = base64_decode($this->_get_value());

					$this->length = $this->base64_ord(substr($this->content, $this->offset, 1)) * 64;
					$this->offset++;
					$this->length += $this->base64_ord(substr($this->content, $this->offset, 1));
					$this->offset++;
					$player->description = base64_decode(substr($this->content, $this->offset, $this->length));
					$this->offset += $this->length;

					$this->template->players[] = $player;
				}

				$this->template->decode_valid = true;

				return $this;
			}

			// pawned-prefix not found
			return $this;
		}

		// no content in between the >< brackets
		return $this;
	}

	/**
	 * @return $this
	 * @throws \chillerlan\GW1Database\GW1DatabaseException
	 */
	public function encode(){
		if(!$this->template instanceof Team){
			throw new GW1DatabaseException('Invalid paw·ned² template!');
		}

		$pwnd = '>';

		foreach($this->template->players as $player){
			$name = str_replace('=', '', base64_encode($player->name));
			$description = str_replace('=', '', base64_encode($player->description));
			$equipment = str_replace('=', '', $player->equipment->code);
			$skills = str_replace('=', '', $player->skills->code);

			$pwnd .= $this->base64_chr(strlen($skills));
			$pwnd .= $skills;

			$pwnd .= $this->base64_chr(strlen($equipment));
			$pwnd .= $equipment;

			foreach($player->weaponsets as $weaponset){
				$weaponset = str_replace('=', '', $weaponset->code);
				$pwnd .= $this->base64_chr(strlen($weaponset));
				$pwnd .= $weaponset;
			}

			$pwnd .= $this->base64_chr(strlen($player->flags));
			$pwnd .= $player->flags;

			$pwnd .= $this->base64_chr(strlen($name));
			$pwnd .= $name;

			$pwnd .= $this->base64_chr(strlen($description) / 64);
			$pwnd .= $this->base64_chr(strlen($description) % 64);
			$pwnd .= $description;
		}

		$pwnd .= '<';

		$pwnd = trim(chunk_split($pwnd, 80));

		$this->template->code_out = $this->template->pawned_prefix.$this->template->pawned_header.PHP_EOL.$pwnd;
		$this->template->encode_valid = true;

		return $this;
	}

}
