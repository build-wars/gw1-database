<?php
/**
 * Class GWBBCodeModule
 *
 * @filesource   GWBBCodeModule.php
 * @created      26.04.2018
 * @package      chillerlan\GW1DB\GWBBCode
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\GWBBCode;

use chillerlan\BBCode\Output\{
	BBCodeModuleAbstract
};
use chillerlan\GW1DB\Data\GWAttrLookup;
use chillerlan\GW1DB\Data\GWProfLookup;
use chillerlan\GW1DB\Data\GWSkillLookup;
use chillerlan\GW1DB\Template\Build;
use chillerlan\GW1DB\Template\Pwnd;

/**
 * @property \chillerlan\GW1DB\GW1DBOptions $options
 */
final class GWBBCodeModule extends BBCodeModuleAbstract{

	/**
	 * @var array
	 */
	protected $tags = ['noparse', 'nobb', 'build', 'skill', 'pwnd'];

	/**
	 * @var array
	 */
	protected $noparse = ['noparse', 'nobb'];

	/**
	 * @return string
	 */
	protected function noparse():string{
		$this->clearPseudoClosingTags()->clearEOL(PHP_EOL);

		// replace image matches {crc32b} with their original content from cache
		$content = preg_replace_callback('/\{(?<key>[a-f\d]{8})\}/i', function($m){
			return $this->cache->get($m['key'])[1] ?? '';;
		}, $this->content);

		return '<pre class="bb-noparse">'.$content.'</pre>'; // $this->match
	}

	/**
	 * @return string
	 */
	protected function nobb():string{
		return $this->noparse();
	}

	/**
	 * @return string
	 */

	protected function build():string{

		// build name & description (user input!)
		$name = $this->attributes['name'] ?? '';
		$desc = $this->attributes['desc'] ?? '';
		$lang = preg_replace('/([^a-z])/i', '', $this->attributes['lang'] ?? $this->options->language);
		$pvp = isset($this->attributes['pvp']) ? strtolower($this->attributes['pvp']) === 'true' : false;
#		$equipment = $this->attributes['equipment'] ?? $this->attributes['equip'] ?? null;
#		$weaponset1 = $this->attributes['weaponset1'] ?? $this->attributes['w1'] ?? null;

		// get primary and secondary profession
		$prof   = explode('/', $this->attributes['prof'] ?? '');
		$pri    = GWProfLookup::prof2id[mb_strtolower(trim($prof[0], "'\"/ "))] ?? 0;
		$sec    = GWProfLookup::prof2id[mb_strtolower(trim($prof[1] ?? 'x' , "'\"/ "))] ?? 0;

		unset($this->attributes['prof'], $this->attributes['name'], $this->attributes['desc'], $this->attributes[$this->options->placeholder_bbtag]);

		$attributes = [];

		foreach($this->attributes as $k => $v){
			$id = GWAttrLookup::attr2id[mb_strtolower(trim(str_replace(['-', ' '], '', $k), "'\" "))] ?? null;

			if($id !== null){
				$attributes[$id] = $v;
			}
		}

		if(empty($this->content)){

			if(empty($this->attributes)){
				return ''; // nothing here
			}

			$code = $this->attributes[$this->options->placeholder_bbtag] ?? $this->attributes['code'] ?? null;

			if(!empty($code)){
				// we have a build code and maybe a name & desc
				return $this->getBuild($code, $name, $desc, $lang, $pvp, $attributes);
			}

			return ''; // profession & attributes only
		}

		// match the [skill]s
		if(preg_match_all('/\{(?<key>[a-f\d]{8})\}/i', $this->content, $matches, PREG_SET_ORDER) > 0){

			// get the matches from cache
			$matches = array_map(function($match){
				return $this->cache->get($match['key'], 0)[0];
			}, $matches);

			// limit to 8 skills
			$skills = array_slice(array_column($matches, 0), 0, 8);

			return (new Build($this->options->language))
				->setSkills($skills)
				->setProfessions($pri, $sec)
				->setAttributes($attributes)
				->setLang($lang)
				->setPvP($pvp)
				->setName($name ?? '')
				->setDescription($desc)
				->toHTML();
		}

		return $this->getBuild($this->content, $name, $desc, $lang, $pvp, $attributes);// build code and maybe a name
	}

	/**
	 * @param string $match
	 * @param string $name
	 * @param string $desc
	 *
	 * @param string $lang
	 * @param bool   $pvp
	 *
	 * @param array  $attributes
	 *
	 * @return string
	 */
	private function getBuild(string $match, string $name = null, string $desc = null, string $lang = null, bool $pvp = null, array $attributes):string{
		$code = explode(';', $match);
		$c = '';
		$p = '/([a-z\d\/\+]+)/i';

		if(isset($code[1]) && preg_match($p, $code[1]) > 0){
			$c    = $code[1];
			$name = $code[0];
		}
		elseif(preg_match($p, $code[0]) > 0){
			$c = $code[0];
		}

		if(!empty($c)){

			$b = (new Build($this->options->language))->decode($c);// todo: language, equipment, weaponsets

			if($b instanceof Build){

				if(!empty($attributes)){
					$b->setAttributes($attributes);
				}

				return $b
					->setLang($lang)
					->setPvP($pvp)
					->setName($name)
					->toHTML();
			}

		}

		return '@m3@'.$match.'@/m3@';
	}

	/**
	 * put the remaining skills into cache too and match them altogether in the post-parser
	 *
	 * @return string
	 */
	protected function skill(){
		$id = GWSkillLookup::skill2id[mb_strtolower(trim(str_replace(['"', '!'], '', $this->content), "' "))] ?? null;

		if($id === null){
			return '@m4@'.$this->match.'@/m4@';
		}

		$rank      = $this->attributes[$this->options->placeholder_bbtag] ?? 0;
		$image    = intval($this->attributes['image'] ?? 0);
		$pvp      = intval($this->attributes['pvp'] ?? 0);
		$huge     = intval($this->attributes['huge'] ?? 0);
		$pri_attr = intval($this->attributes['pri'] ?? 0);
		$lang     = preg_replace('/([^a-z])/i', '', $this->attributes['lang'] ?? $this->options->language);

		$k = hash('crc32b', $this->match);
		$this->cache->set($k, [[$id, $rank, $pvp, $image, $lang, $pri_attr, $huge], $this->match]);

		return '{'.$k.'}';
	}

	/**
	 * @return string
	 */
	protected function pwnd(){
		$pwnd = str_replace(['&gt;', '&lt;', $this->options->placeholder_eol],['>', '<', ''], $this->content);

		$p = (new Pwnd($this->options->language))->decode($pwnd); // @todo

		if($p instanceof Pwnd){
			return $p->toHTML();
		}

		return '@pwnd@'.$pwnd.'@/pwnd@';
	}
}
