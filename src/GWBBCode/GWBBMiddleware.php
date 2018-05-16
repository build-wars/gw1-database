<?php
/**
 * Class GWBBMiddleware
 *
 * @filesource   GWBBMiddleware.php
 * @created      26.04.2018
 * @package      chillerlan\GW1DB\GWBBCode
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\GWBBCode;

use chillerlan\BBCode\ParserMiddlewareInterface;
use chillerlan\GW1DB\Data\GWSkillLookup;
use chillerlan\GW1DB\Template\Skill;
use chillerlan\Traits\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

final class GWBBMiddleware implements ParserMiddlewareInterface{

	/**
	 * @var \chillerlan\GW1DB\GW1DBOptions
	 */
	protected $options;

	/**
	 * @var \Psr\SimpleCache\CacheInterface
	 */
	protected $cache;

	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $logger;

	/**
	 * GWBBMiddleware constructor.
	 *
	 * @param \chillerlan\Traits\ContainerInterface $options
	 * @param \Psr\SimpleCache\CacheInterface       $cache
	 * @param \Psr\Log\LoggerInterface              $logger
	 */
	public function __construct(ContainerInterface $options, CacheInterface $cache, LoggerInterface $logger){
		$this->options = $options;
		$this->cache   = $cache;
		$this->logger  = $logger;
	}

	/**
	 * @inheritdoc
	 */
	public function pre(string $bbcode):string{

		// todo: replace existing <br> tags with eol placeholder

		// match out GWShack/Wartower.de shortcuts
		$bbcode = preg_replace_callback('#\[\[([^\]/]*)](\])?#is', [$this, 'replaceGWShack'], $bbcode);
		// match out single bracket skill tags
		$bbcode = preg_replace_callback('#\[([^]]*)?]#is', [$this, 'replaceSingleBracket'], $bbcode);
		// match out GW build chat codes and convert to a build tag
		// [DF-Caller;OQZDAswzQqDuNmOTP2kBBiOwl] -> [build]DF-Caller;OQZDAswzQqDuNmOTP2kBBiOwl[/build]
		// [;OQZDAswzQqDuNmOTP2kBBiOwl]          -> [build]OQZDAswzQqDuNmOTP2kBBiOwl[/build]
		// not using the "name" parameter here because the build name may contain quotes which will be converted later
		$bbcode = preg_replace("#\[([^;\]]*);([a-z/\d\+]*)\]#is", '[build]$1;$2[/build]', $bbcode);

		return $bbcode;
	}

	/**
	 * @inheritdoc
	 */
	public function post(string $bbcode):string{

		// replace 8 skills (the substitutes) with no space in between (that are not enclosed in a build tag) with a build
/*		$bbcode = preg_replace_callback('#((?:\{[\da-f]{8}\}){8})#i', function($m){

			$skills = array_map(function($match){
				return $this->cache->get($match, 0)[0][0];
			}, explode('}{', trim($m[1], '}{')));

			return '@b2@'.((new Build)->fromTplData($skills, [])->toHTML()).'@/b2@';
		}, $bbcode);
*/
		$bbcode = preg_replace_callback('/\{(?<key>[a-f\d]{8})\}/is', [$this, 'parseSkills'], $bbcode);

		$url = $this->options->gwdbURL.'/img/';

		$bbcode = str_replace( // @todo
			['{IMG_SKILL_64}', '{IMG_SKILL_256}', '{IMG_PROF_64}', '{IMG_PROF_32}', '{ICONS_MISC}'],
			[$url.'skills/64', $url.'skills/256', $url.'professions/64', $url.'professions/32', $url.'misc']
			, $bbcode);

		return $bbcode;
	}

	/**
	 * pre-parser
	 *
	 * match out GWShack/Wartower.de shortcuts, return clean single brackets if no skill is matched in first run
	 *
	 * [[skillname]         -> [skill]skillname[/skill]
	 * [[skillname@10+1+3]  -> [skill=14]skillname[/skill]
	 * [[skillname]]        -> [skill image=1]skillname[/skill]
	 * [[skillname@10+1+3]] -> [skill=14 image=1]skillname[/skill]
	 *
	 * @param array $match
	 *
	 * @return string
	 */
	protected function replaceGWShack(array $match):string{
		return $this->skill2cache($match[1], $match[0], str_replace(['[', ']'], '', $match[0]), 0, intval($match[2] ?? 0));
	}

	/**
	 * pre-parser
	 *
	 * match out single bracket skill tags, leave other tags untouched
	 *
	 * [skillname] -> [skill image=1]skillname[/skill]
	 * [skillname@15] -> [skill=15 image=1]skillname[/skill]
	 *
	 * @param array $match
	 *
	 * @return string
	 */
	protected function replaceSingleBracket(array $match):string{
		return $this->skill2cache($match[1], $match[0], $match[0], 0, 1);
	}

	/**
	 * pre-parser
	 *
	 * since we don't know whether or not these skills are in a [build] tag,
	 * we just replace them with a hash and put the match data in the cache for later
	 *
	 * @param string $value
	 * @param string $match
	 * @param string $return_on_null
	 * @param int    $pvp
	 * @param int    $img
	 *
	 * @return string
	 */
	protected function skill2cache(string $value, string $match, string $return_on_null, int $pvp, int $img){
		$skill = explode('@', $value);

		if(empty($skill[0])){
			return '';
		}

		$id = GWSkillLookup::skill2id[mb_strtolower(trim(str_replace(['"', '!'], '', $skill[0]), "' "))] ?? null;

		if($id === null){
			return $return_on_null;
		}

		$k = hash('crc32b', $match);
		// [id, rank, pvp, img, lang, pri_rank]
		$this->cache->set($k, [[$id, $skill[1] ?? 0, $pvp, $img, $this->options->language, 0, 0], $match]);

		return '{'.$k.'}';
	}

	/**
	 * post-parser
	 *
	 * replace skill substitutes with either images or links
	 *
	 * @param array $match
	 *
	 * @return string
	 */
	protected function parseSkills(array $match):string{
		$skill = $this->cache->get($match['key']);

		// not in cache, huh?
		if($skill === null){
			return '';
		}

		[$id, $rank, $pvp, $image, $lang, $pri_rank, $huge] = $skill[0];

		return (new Skill($id, $this->options->language))
			->setAttributeRank($rank, $pri_rank)
			->setPvP((bool)$pvp)
			->setLang(strtolower($lang))
			->toHTML((bool)$image, $huge, false);
	}

}
