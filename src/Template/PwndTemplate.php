<?php
/**
 * Class PwndTemplate
 *
 * @filesource   PwndTemplate.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

/**
 * Thanks to Antodias/GWCom.de!
 */
class PwndTemplate extends TemplateAbstract{

	/**
	 * @var string
	 */
	protected $pawned_prefix = 'pwnd0000';

	/**
	 * @var string
	 */
	protected $pawned_header = '?PwndTemplate https://github.com/codemasher/gw1-database';

	/**
	 * @param string $template
	 *
	 * @return array
	 * @throws \chillerlan\GW1DB\Template\TemplateException
	 */
	public function decode(string $template):array{
		$template = str_replace(["\r", "\n"], '', $template);
		$start    = strpos($template, '>');
		$end      = strpos($template, '<', $start) - 1;

		if($end > $start && $end !== 0){
			$header  = substr($template, 0, $start);
			$content = substr($template, $start + 1, $end - $start);

			if(substr($header, 0, 8) === $this->pawned_prefix){
				$this->pawned_header = substr($header, 8);
				$builds = [];
				$offset = 0;

				while($offset < strlen($content)){

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;
					$build['skills'] = substr($content, $offset, $length);
					$offset += $length;

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;
					$build['equipment'] = substr($content, $offset, $length);
					$offset += $length;

					for($i = 0; $i < 3; $i++){
						$length = $this->base64_ord(substr($content, $offset, 1));
						$offset++;
						$build['weaponsets'][$i] = substr($content, $offset, $length);
						$offset += $length;
					}

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;
					$build['flags'] = substr($content, $offset, $length);
					$offset += $length;

					$length = $this->base64_ord(substr($content, $offset, 1));
					$offset++;
					$build['player'] = substr($content, $offset, $length); // base64_decode
					$offset += $length;

					$length = $this->base64_ord(substr($content, $offset, 1)) * 64;
					$offset++;
					$length += $this->base64_ord(substr($content, $offset, 1));
					$offset++;
					$build['description'] = substr($content, $offset, $length); // base64_decode
					$offset += $length;

					$builds[] = $build;
				}

				return $builds;
			}

			// pawned-prefix not found
			throw new TemplateException('pawned-prefix not found');
		}

		// no content in between the >< brackets
		throw new TemplateException('no content');
	}

	/**
	 * @param array $build
	 *
	 * @return string
	 */
	public function encode(array $build):string{
		$pwnd = '';

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
			$pwnd .= $b['player'];

			$pwnd .= $this->base64_chr(strlen($b['description']) / 64);
			$pwnd .= $this->base64_chr(strlen($b['description']) % 64);
			$pwnd .= $b['description'];
		}

		return $this->pawned_prefix.$this->pawned_header.PHP_EOL.trim(chunk_split('>'.$pwnd.'<', 80));
	}

}
