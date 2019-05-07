<?php
/**
 * Class Skill
 *
 * @filesource   Skill.php
 * @created      13.04.2018
 * @package      chillerlan\GW1DB\Template
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Template;

use chillerlan\GW1DB\Data\{GWDataMisc, GWSkillDB};

class Skill extends TemplateAbstract{

	protected const PROF_FN_NAME = [
		0 => 'none', 1 => 'warrior', 2 => 'ranger', 3 => 'monk', 4 => 'necromancer', 5 => 'mesmer',
		6 => 'elementalist', 7 => 'assassin', 8 => 'ritualist', 9 => 'paragon', 10 => 'dervish'
	];

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	protected $rank;

	/**
	 * @var string
	 */
	protected $primaryRank;

	/**
	 * @var int
	 */
	protected $val;

	/**
	 * @var int
	 */
	protected $pri_val;

	/**
	 * @var string
	 */
	protected $skillname;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var array
	 */
	protected $stats;

	/**
	 * @var array
	 */
	protected $extraAttr;

	/**
	 * @var array
	 */
	protected $prog_val;

	/**
	 * @var int
	 */
	protected $creatureLevel;

	/**
	 * Skill constructor.
	 *
	 * @param int|null    $skillID
	 * @param bool|null   $pvp
	 * @param string|null $lang
	 */
	public function __construct(int $skillID, bool $pvp = null, string $lang = null){
		$this->id   = $skillID;

		$this
			->setLang($lang ?? 'en')
			->setPvP($pvp ?? false)
		;
	}

	/**
	 * @return array
	 */
	protected function getSkilldata():array{
		$skilldata = GWSkillDB::id2skill[$this->id] ?? GWSkillDB::id2skill[0];

		foreach(['name', 'desc', 'concise'] as $p){
			$skilldata['pve'][$p] = $skilldata['pve'][$p][$this->lang];

			if($skilldata['pvp'] !== null){
				$skilldata['pvp'][$p] = $skilldata['pvp'][$p][$this->lang];
			}
		}

		$prof_id                 = $skilldata['profession'];
		$prof_data               = GWDataMisc::professions[$prof_id];
		$prof_data['id']         = $prof_id;
		$prof_data['name']       = $prof_data['name'][$this->lang];
		$prof_data['abbr']       = $prof_data['abbr'][$this->lang];
		$skilldata['profession'] = $prof_data;

		$attr_id                = $skilldata['attribute'];
		$attr_data              = GWDataMisc::attributes[$attr_id];
		$attr_data['id']        = $attr_id;
		$attr_data['name']      = $attr_data['name'][$this->lang];
		$attr_data['abbr']      = $attr_data['abbr']['en'];
		$skilldata['attribute'] = $attr_data;

		$skilldata['campaign']  = GWDataMisc::campaigns[$skilldata['campaign']]['name'][$this->lang];

		$this->stats = $skilldata[$this->isPvP && $skilldata['split'] ? 'pvp' : 'pve'];

		unset($skilldata['pve'], $skilldata['pvp']);

		return $skilldata;
	}

	/**
	 * @param string      $rank
	 * @param string|null $primaryRank
	 *
	 * @return \chillerlan\GW1DB\Template\Skill
	 */
	public function setAttributeRank(string $rank, string $primaryRank = null):Skill{
		$this->rank     = $rank;
		$this->primaryRank = $primaryRank;

		return $this;
	}

	/**
	 * @param bool|null $image
	 * @param bool|null $image_huge
	 * @param bool|null $inBuild
	 *
	 * @return string
	 */
	public function toHTML(bool $image = null, bool $image_huge = null, bool $inBuild = null):string{
		$desc            = $this->getDescription();
		$prof_pri        = GWDataMisc::professions[$this->pri];
		$pcn             = $this::PROF_FN_NAME[$this->data['profession']['id']];
		$this->skillname = $this->sanitize(stripslashes($this->stats['name']));

		$a = [
			$this->data['attribute']['id']   => $this->rank ?? 0,
			$this->data['profession']['pri'] => $this->primaryRank > 0 ? $this->primaryRank : null,
		];

		$this->setAttributes($a);

		$this->cssClass = [
			'gwbb-skill',
			$this->data['elite'] ? 'elite' : null,
			$this->id === 0 ? 'noskill' : null,
			in_array($this->stats['type'], $prof_pri['effect'], true) ? 'effect' : null,
		];

		if(!$inBuild){
			$this->dataset = [
				'lang' => $this->lang,
				'attr' => $this->getAttributeString(),
				'pvp'  => $this->isPvP && $this->data['split'] ? (int)$this->isPvP : null,
			];
		}

		$this->dataset['id'] = $this->id;

		if($image ?? true){ // default to image
			return $this->image($pcn, $image_huge ?? false);
		}

		return $this->link($pcn);
	}

	/**
	 * @param string $pcn
	 * @param bool   $huge
	 *
	 * @return string
	 */
	protected function image(string $pcn, bool $huge):string{
		$this->cssClass[] = $pcn;

		$src = '{IMG_SKILL_64}';

		// huge if true
		if($huge === true){ // @todo: check if available (or upscale the no-profession-skill images)
			$this->cssClass[] = 'huge';

			$src = '{IMG_SKILL_256}';
		}

		return '<img src="'.$src.'/'.$this->id.'.png" alt="'.$this->skillname.'" class="'.$this->getCssClass().'" '.$this->getDataset().'/>';
	}

	/**
	 * @param string $pcn
	 *
	 * @return string
	 */
	protected function link(string $pcn):string{
		$lvl = $this->normalizeAttributeLevel($this->val ?? '');

		$attr_lvl  = $lvl['total'] > 0 && $this->data['attribute']['id'] !== -1 ? $lvl['total_str'].' ' : '';
		$attr_name = GWDataMisc::attributes[$this->data['attribute']['id']]['name'][$this->lang];

		return '<span class="gwbb-link '.$pcn.'">[<a class="'.$this->getCssClass().'" '.$this->getDataset().'>'.$this->skillname.'</a> <span class="attr">'.$attr_lvl.$attr_name.'</span>]</span>';
	}

	/**
	 * @param array|null $extraAttr
	 *
	 * @return array
	 */
	public function getDescription(array $extraAttr = null):array{
		$this->data      = $this->getSkilldata();
		$this->extraAttr = $extraAttr ?? [];
		$this->val       = $this->attributes[$this->data['attribute']['id']]['total'] ?? 0;
		$this->pri_val   = $this->attributes[GWDataMisc::professions[$this->pri]['pri']]['total'] ?? 0;
		$this->prog_val  = [];
		$desc            = $this->stats['desc'];
		$concise         = $this->stats['concise'];
		$additional      = '';

		// skill progression, first pass
		$p1 = '/(?:(?<p1>stufe|level) )?(?<val0>\d+)[.]{2,3}(?<val15>\d+)(?: (?<p2>seconds?|sekunden?))?/i';

		$desc    = preg_replace_callback($p1, [$this, 'progressionReplace1'], $desc);
		$concise = preg_replace_callback($p1, [$this, 'progressionReplace1'], $concise);

		// skill progression, second pass - weapon duration for non-progression values
		if($this->stats['type'] === 27 && $this->pri === 8 && $this->pri_val && $this->id !== 983){
			$p2 = '/(?<val>\d+) (?<p1>seconds?|sekunden?)/i';

			$desc    = preg_replace_callback($p2, [$this, 'progressionReplace2'], $desc);
			$concise = preg_replace_callback($p2, [$this, 'progressionReplace2'], $concise);
		}

		// additional creature health
		if(in_array($this->stats['type'], GWDataMisc::SKILL_A_SPAWNING)
		   || in_array($this->id, GWDataMisc::SKILLS_MINION) || $this->id === 1239){
			$additional .= $this->creature();
		}

		// additional primary attribute effect
		if($this->pri && $this->pri_val){
			$additional .= $this->additionalPrimary();
		}

		return [
			'data'        => $this->data,
			'stats'       => $this->stats,
			'description' => $desc,
			'concise'     => $concise,
			'additional'  => $additional,
			'progression' => $this->prog_val,
		];
	}

	/**
	 * @param int $val0
	 * @param int $val15
	 * @param int $attr_val
	 *
	 * @return int
	 */
	public function progression(int $val0, int $val15, int $attr_val):int{
		$value = ($val15 - $val0) / 15;

		if(in_array($this->data['attribute']['id'], [-5, -4])){ // Lux/Kurz
			$value = $value * ($attr_val + floor($attr_val / 4));
		}
		else if(in_array($this->data['attribute']['id'], [-9, -8, -7, -6])){ // EOTN titles
			$value = $value * ($attr_val + floor($attr_val / 2));
		}
		else{
			$value = $value * $attr_val;
		}

		return (int)round($value) + $val0;
	}

	/**
	 * @param array $matches
	 *
	 * @return string
	 */
	protected function progressionReplace1(array $matches):string{
		$val0   = $matches['val0'];
		$val15  = $matches['val15'];
		$p1     = $matches['p1'] ?? null;
		$p2     = $matches['p2'] ?? null;

		$effect = $this->progression($val0, $val15, $this->val);
		$scCheck = $this->pri === 5 && in_array(1340, $this->extraAttr) && $this->stats['type'] === 21 && $this->id !== 63;
		$prog = [];

		// collect the progression levels for the table
		for($i = 0; $i < 22; $i++){
			// todo: other bonus attribute skills
			$prog[$i] = $this->progression($val0, $val15, $i);
		}

		$this->prog_val[$val0.'-'.$val15] = $prog;

		// fast casting -> symbolic celerity effect
		if($this->pri_val && $scCheck){
			return $this->professionText('mesmer', $this->progression($val0, $val15, $this->pri_val))
			       .' ('.$this->effectText($this->val ? $effect : $val0).')'
			       .(!empty($p2) ? ' '.$p2 : '');
		}

		// spawning power -> weapon spell duration
		if($this->pri === 8 && $this->pri_val
		   // sundering weapon fix
		   && !($this->id === 2148 && $val15 === '20')
		){

			if($this->stats['type'] === 27 && $this->val){
				$text = $this->professionText('ritualist', $this->weaponDuration($effect)).' ('.$this->effectText($effect).')';

				if(in_array($this->id, GWDataMisc::SKILL_FIX_SPAWNING)){

					if($p2 && preg_match('/(seconds?|sekunden?)/i', $p2)){
						return $text.' '.$p2;
					}

					return $this->effectText($effect);
				}

				return $text.(!empty($p2) ? ' '.$p2.' ' : '');
			}
		}

		// fetch the creature level (if any)
		if(in_array($this->stats['type'], GWDataMisc::SKILL_A_SPAWNING) || in_array($this->id, GWDataMisc::SKILLS_MINION) || $this->id === 1239){
			if($p1 && preg_match('/(stufe|level)/i', $p1)){
				$this->creatureLevel = $effect;
			}
		}

		return ($p1 ? $p1.' ' : '').$this->effectText($this->val ? $effect : $val0 . '...' . $val15).($p2 ? ' '.$p2 : '') ;
	}

	/**
	 * @param array $matches
	 *
	 * @return string
	 */
	protected function progressionReplace2(array $matches):string{
		return $this->professionText('ritualist', $this->weaponDuration($matches['val'])).' ('.$matches['val'].') '.$matches['p1'];
	}

	protected function effectText(string $str):string{
		return '<span class="effect">'.$str.'</span>';
	}

	protected function professionText(string $prof, string $str):string{
		return '<span class="'.$prof.'">'.$str.'</span>';
	}

	protected function additionalPrimary():string{
		return '<h2>'.$this->effectText($this->pri_val).' '.GWDataMisc::attributes[GWDataMisc::professions[$this->pri]['pri']]['name'][$this->lang].'</h2>'.
		       '<p class="'.$this::PROF_FN_NAME[$this->pri].'">'.call_user_func([$this, $this::PROF_FN_NAME[$this->pri]]).'</p>';
	}

	protected function weaponDuration(int $duration):int{
		return (int)round($duration * (1 + $this->pri_val * 0.04));
	}

	protected function creature():string{
		$health = $this->creatureLevel * 20;
		$armor = 6 * $this->creatureLevel + 3;
		$spHealth = null;
		$d = null;

		// wonky guildwiki armor/level values - no guarantee
		if(in_array($this->id, GWDataMisc::SKILLS_MINION)){
			$health += 80;
			$armor = 3.75 * $this->creatureLevel + 5;

			switch($this->id){
				case 84: $armor = 2.84 * $this->creatureLevel + 3.1; break;
				case 85: $armor = 2.9 * $this->creatureLevel + 1.25; break;
			}
		}

		if($this->pri === 8 && $this->pri_val){
			$spHealth = $health * (1 + $this->pri_val * 0.04);
			$d = sprintf(
				GWDataMisc::DESC_ADDITIONAL['creature']['spawning'][$this->lang],
				$this->effectText(round($health)),
				$this->effectText(round($armor)),
				$this->professionText('ritualist', round($spHealth))
			);
		}
		else{
			$d = sprintf(
				GWDataMisc::DESC_ADDITIONAL['creature']['other'][$this->lang],
				$this->effectText(round($health)),
				$this->effectText(round($armor)), round($spHealth)
			);
		}

		return '<p>'.$d.'</p>';
	}

	protected function warrior():string{
		$d = in_array($this->stats['type'], GWDataMisc::SKILL_A_STRENGTH)
			? GWDataMisc::DESC_ADDITIONAL['warrior']['self'][$this->lang]
			: GWDataMisc::DESC_ADDITIONAL['warrior']['other'][$this->lang];

		return sprintf($d, $this->effectText($this->pri_val));
	}

	protected function ranger():string{
		$d = $this->stats['energy'] && (
			$this->data['profession']['id'] === 2
			|| in_array($this->stats['type'], GWDataMisc::SKILL_A_EXPERTISE)
			|| in_array($this->id, GWDataMisc::SKILLS_TOUCH)
		)
			? GWDataMisc::DESC_ADDITIONAL['ranger']['self'][$this->lang]
			: GWDataMisc::DESC_ADDITIONAL['ranger']['other'][$this->lang];

		return sprintf($d, $this->effectText($this->pri_val * 4));
	}

	protected function monk():string{

		if(in_array($this->id, GWDataMisc::SKILLS_DF_TARGET)){
			$d = GWDataMisc::DESC_ADDITIONAL['monk']['target'][$this->lang];
		}
		elseif(in_array($this->id, GWDataMisc::SKILLS_DF_ADD)){
			$d = GWDataMisc::DESC_ADDITIONAL['monk']['add'][$this->lang];
		}
		elseif(in_array($this->id, GWDataMisc::SKILLS_DF_SELF)){
			$d = GWDataMisc::DESC_ADDITIONAL['monk']['self'][$this->lang];
		}
		else{
			$d = GWDataMisc::DESC_ADDITIONAL['monk']['other'][$this->lang];
		}

		return sprintf($d, $this->effectText(round(3.2 * $this->pri_val)));
	}

	protected function necromancer():string{
		return sprintf(GWDataMisc::DESC_ADDITIONAL['necromancer']['self'][$this->lang], $this->effectText($this->pri_val));
	}

	protected function mesmer():string{
		$calc1 = round(100 * (1 - ($this->pri_val * 0.03))); // signet activation and spell recharge
		$calc2 = round(100 * pow(2, ($this->pri_val * -1) / 15)); // spell activation
		$d     = null;

		// signets
		if($this->stats['type'] === 21){
			$l1 = GWDataMisc::DESC_ADDITIONAL['mesmer']['signet1'][$this->lang];
			$l2 = GWDataMisc::DESC_ADDITIONAL['mesmer']['signet2'][$this->lang];
			$sc = in_array(1340, $this->extraAttr) && $this->data['attribute']['id'] !== -1;

			if($this->data['profession']['id'] === 5){
				$d = $sc && $this->id !== 63 ? $l1 : $l2;
			}
			elseif($this->stats['activation'] >= 2){
				$d = $sc ? $l1 : $l2;
			}
			else{
				$d = $sc ? GWDataMisc::DESC_ADDITIONAL['mesmer']['signet3'][$this->lang] : false;
			}

			$d = sprintf($d, $this->effectText($calc1));
		}
		// spells
		else if(in_array($this->stats['type'], GWDataMisc::SKILL_A_FASTCAST)){

			if($this->data['profession']['id'] === 5){
				$d = sprintf(
					GWDataMisc::DESC_ADDITIONAL['mesmer']['spell1'][$this->lang],
					$this->effectText($calc2),
					$this->effectText($calc1)
				);
			}
			elseif($this->stats['activation'] >= 2){
				$d = sprintf(GWDataMisc::DESC_ADDITIONAL['mesmer']['spell2'][$this->lang], $this->effectText($calc2));
			}

		}

		if(!$d){
			$d = sprintf(
				GWDataMisc::DESC_ADDITIONAL['mesmer']['spell3'][$this->lang],
				$this->effectText($calc2),
				$this->effectText($calc1)
			);
		}

		return $d;
	}

	protected function elementalist():string{
		return sprintf(GWDataMisc::DESC_ADDITIONAL['elementalist']['self'][$this->lang], $this->effectText($this->pri_val * 3));
	}

	protected function assassin():string{
		// todo: check for critical eye etc.
		return sprintf(
			GWDataMisc::DESC_ADDITIONAL['assassin']['self'][$this->lang],
			$this->effectText($this->pri_val),
			$this->effectText(floor(($this->pri_val + 2) / 5))
		);
	}

	protected function ritualist():string{

		if($this->stats['type'] === 27){
			$d = GWDataMisc::DESC_ADDITIONAL['ritualist']['weaponspell'][$this->lang];
		}
		elseif(in_array($this->stats['type'], GWDataMisc::SKILL_A_SPAWNING) || in_array($this->id, GWDataMisc::SKILLS_MINION) || $this->id === 1239){
			$d = GWDataMisc::DESC_ADDITIONAL['ritualist']['creature'][$this->lang];
		}
		else{
			$d = GWDataMisc::DESC_ADDITIONAL['ritualist']['other'][$this->lang];
		}

		return sprintf($d, $this->effectText($this->pri_val * 4));
	}

	protected function paragon():string{
		$d = in_array($this->stats['type'], GWDataMisc::SKILL_A_LEADERSHIP)
			? GWDataMisc::DESC_ADDITIONAL['paragon']['self'][$this->lang]
			: GWDataMisc::DESC_ADDITIONAL['paragon']['other'][$this->lang];

		return sprintf($d, $this->effectText(floor($this->pri_val / 2)));
	}

	protected function dervish():string{
		$d = in_array($this->stats['type'], GWDataMisc::SKILL_A_MYSTICISM)
			? GWDataMisc::DESC_ADDITIONAL['dervish']['self'][$this->lang]
			: GWDataMisc::DESC_ADDITIONAL['dervish']['other'][$this->lang];

		return sprintf($d, $this->effectText($this->pri_val * 4), $this->effectText($this->pri_val));
	}

}
