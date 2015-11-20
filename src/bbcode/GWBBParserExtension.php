<?php
/**
 * @filesource   GWBBParserExtension.php
 * @created      07.11.2015
 * @package      chillerlan\GW1Database\bbcode
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\GW1Database\bbcode;

use chillerlan\bbcode\ParserExtensionInterface;
use chillerlan\Framework\Core\Traits\ClassLoaderTrait;
use chillerlan\GW1Database\Database\Connectors\ChillerlanFramework;
use chillerlan\GW1Database\Database\Connectors\GWDBConnectorInterface;
use chillerlan\GW1Database\Skills\Build;
use chillerlan\GW1Database\Skills\SkillTranscoder;

/**
 * Class GWBBParserExtension
 */
class GWBBParserExtension implements ParserExtensionInterface{
	use ClassLoaderTrait;

	/**
	 * @var \chillerlan\GW1Database\bbcode\GWBBParserOptions
	 */
	protected $options;

	/**
	 * @var \chillerlan\GW1Database\Database\Connectors\GWDBConnectorInterface
	 */
	protected $gwdb;

	/**
	 * @var string
	 */
	protected $bbcode;

	/**
	 * ParserExtension constructor.
	 *
	 * @param \chillerlan\GW1Database\bbcode\GWBBParserOptions $options
	 */
	public function __construct(GWBBParserOptions $options){
		$this->options = $options;
		$this->gwdb = $this->load_class($this->options->connector, GWDBConnectorInterface::class, $options);
	}

	/**
	 * Pre-parser
	 *
	 * The bbcode you receive here is not sanitized, the sanitizer runs after this step.
	 * Do anything here to the unparsed bbcode, just don't touch newlines - these will be replaced with a placeholder after this step.
	 *
	 * @param string $bbcode bbcode
	 *
	 * @return string preparsed bbcode
	 */
	public function pre($bbcode){
		$this->bbcode = $bbcode;

		/**
		 * match out GWShack/Wartower.de shortcuts
		 *
		 * [[skillname]         -> [skill]skillname[/skill]
		 * [[skillname@10+1+3]  -> [skill=14]skillname[/skill]
		 * [[skillname]]        -> [skill image=1]skillname[/skill]
		 * [[skillname@10+1+3]] -> [skill=14 image=1]skillname[/skill]
		 *
		 * @todo optimize pattern
		 */
		$pattern = '#\[\[(?<name>[^\]/]*)](?<image>\])?#';
		$this->bbcode = preg_replace_callback($pattern, function ($bb){
			$name = explode('@', $bb['name']);
			$attribute_level = 0;

			if(!empty($name[1])){
				$values = explode('+', $name[1]);
				foreach($values as $v){
					$attribute_level += intval($v);
				}
			}

			return !empty($name[0]) ? '[skill'.($attribute_level > 0 ? '='.$attribute_level : '').(isset($bb['image']) ? ' image=1' : '').']'.$name[0].'[/skill]' : '';
		}, $this->bbcode);

		/**
		 * match out GW build chat codes and convert to GWShack [build] tag
		 *
		 * [DF-Caller;OQZDAswzQqDuNmOTP2kBBiOwl] -> [build=DF-Caller;OQZDAswzQqDuNmOTP2kBBiOwl][/build]
		 * [;OQZDAswzQqDuNmOTP2kBBiOwl]          -> [build=OQZDAswzQqDuNmOTP2kBBiOwl][/build]
		 */
		$this->bbcode = preg_replace_callback("#\[(?<name>[^';\r\n\t\]]*);(?<code>[a-z/\d\+]+)\]#i", function ($bb){
			return '[build=\''.(!empty($bb['name']) ? $bb['name'] : '').';'.$bb['code'].'\'][/build]';
		}, $this->bbcode);


		return $this->bbcode;
	}

	/**
	 * Post-parser
	 *
	 * Use this method in case you want to alter the parsed bbcode.
	 * The newline placeholders are still available and any remaining will be removed in the last step before output
	 *
	 * Example: you want the "img" bbcode to use database images instead of user URLs.
	 * You'd go and change the tag so that it only accepts digits like [img=123456]
	 * and replace any occurence with a unique placeholder like {IMG|ID}.
	 * Now the post-parser gets into play: you preg_match_all() out all your placeholders,
	 * grab the images in a single query from the database and replace them with their respective <img> tag
	 * or whatever replacement and any corrupt id with a placeholder image. Profit!
	 *
	 * @param string $bbcode bbcode
	 *
	 * @return string postparsed bbcode
	 */
	public function post($bbcode){

		$skills_search = [];
		$skills_search_id = [];

		$skillsets = [];

		$pattern = '/\{(?<type>[A-Z]+)(?:\|)(?<content>[^\}]*)\}/';
		if(preg_match_all($pattern, $bbcode, $matches, PREG_SET_ORDER) > 0){
#			var_dump($matches);

			$st = new SkillTranscoder;

			// collect all skills
			foreach($matches as $key => $match){
				switch($match['type']){
					case 'BUILD':
						$_skills = explode('|', explode('#', $match['content'])[2]);
						$skills_search = array_merge($skills_search, $_skills);
						$build = new Build;
						$build->skill_search = $_skills;
						$build->pcre_match = $match[0];
						$skillsets[] = $build;
						break;
					case 'BUILDCODE':
						$build = new Build(explode('|', $match['content'])[1]);
						$build->pcre_match = $match[0];
						$build = $st->set_template($build)->decode()->get_template();
						$skills_search_id = array_merge($skills_search_id, $build->skills);
						$skillsets[] = $build;
						break;
					case 'SKILL':
						$skills_search[] = explode('|', $match['content'])[0];
						break;
				}
			}
			$skills_search_id = array_unique($skills_search_id);

			$sql = 'SELECT * FROM gw1_skilldata WHERE id in('.substr(str_repeat('?,', count($skills_search_id)), 0, -1).')';

			$x = $this->gwdb->prepared($sql, $skills_search_id);
			var_dump($x);
		}


		return $bbcode;
	}

}
