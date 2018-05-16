<?php
/**
 * Class TemplateAbstract
 *
 * @filesource   TemplateAbstract.php
 * @created      29.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\GW1DB\Data\GWDataMisc;

abstract class TemplateAbstract implements TemplateInterface{

	protected $defaultLang = 'en';
	protected $lang;
	protected $isPvP       = false;
	protected $attributes  = []; // [id => value]
	protected $pri         = 0;
	protected $sec         = 0;
	protected $cssClass    = [];
	protected $dataset     = []; // [name => value]

	/**
	 * @param string $str
	 *
	 * @return string
	 */
	protected function sanitize(string $str):string {
		return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5|ENT_SUBSTITUTE, 'UTF-8', false);
	}

	/**
	 * @inheritdoc
	 */
	public function setLang(string $lang):TemplateInterface{
		$this->lang = in_array($lang, ['de', 'en'], true) ? $lang : $this->defaultLang;

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setPvP(bool $pvp):TemplateInterface{
		$this->isPvP = $pvp;

		return $this;
	}

	/**
	 * @param int|null $pri
	 * @param int|null $sec
	 *
	 * @return \chillerlan\GW1DB\Template\Skill
	 */
	public function setProfessions(int $pri = null, int $sec = null):TemplateInterface{
		$this->pri = min(10, max(0, $pri));
		$this->sec = min(10, max(0, $sec));

		return $this;
	}

	/**
	 * @param array $attributes [id => level]
	 *
	 * @return \chillerlan\GW1DB\Template\TemplateInterface
	 */
	public function setAttributes(array $attributes):TemplateInterface{
		// @todo: attribute level including runes from equipment code
		$this->attributes = [];

		foreach($attributes as $id => $level){

			if(!is_int($id) || !array_key_exists($id, GWDataMisc::attributes) || $level === null){
				continue;
			}

			$this->attributes[$id] = $this->normalizeAttributeLevel($level);
		}

		return $this;
	}

	/**
	 * @return string
	 */
	protected function getAttributeString():?string{
		$attributes = [];

		foreach($this->attributes as $k => $v){
			$attributes[] = $k.':'.max(0, min($v['total'], 21)); // clamp to 21
		}

		if(empty($attributes)){
			return null;
		}

		return implode(',', $attributes);
	}

	/**
	 * @return string
	 */
	protected function getCssClass():string{
		$cssClass = [];

		foreach($this->cssClass as $class){

			if($class === null){
				continue;
			}

			$cssClass[] = $class;
		}

		return implode(' ', $cssClass);
	}

	/**
	 * @return string
	 */
	protected function getDataset():string {
		$dataset = [];

		foreach($this->dataset as $f => $v){

			if($v === null){
				continue;
			}

			$dataset[] = 'data-'.$f.'="'.$v.'"';
		}

		return implode(' ', $dataset);
	}

	/**
	 * normalize attribute values
	 *
	 * 12+1+3 -> 12+4
	 * 16     -> 12+4
	 *
	 * @param string $match
	 *
	 * @return array
	 */
	protected function normalizeAttributeLevel(string $match):array {

		$values = array_map(function($v){
			return intval($v);
		}, explode('+', preg_replace('/([^\d\+]+)/', '', $match)));

		rsort($values, SORT_NUMERIC);

		$base  = array_shift($values);
		$extra = 0;

		if($base > 12){
			$extra = $base - 12;
			$base  = 12;
		}

		if(!empty($values)){

			foreach($values as $v){
				$v      = intval($v);
				$extra += $v;
			}

		}

		// attribute levels > 33 result in negative activation & recharge for mesmer - THE CHRONOMANCER IS REAL
		$extra = max(0, min($extra, 9)); // clamp to 9 extra -> 21 max

		//@todo
		return[
			'base'      => $base,
			'extra'     => $extra,
			'total'     => $base + $extra,
			'total_str' => $extra > 0 ? $base.'+'.$extra : (string)$base,
		];
	}

}
