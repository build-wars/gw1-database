/**
 * @filesource   GWTooltip.js
 * @created      28.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

'use strict';

(o => {

// https://jamie.build/const

const LANGUAGES = ['de', 'en'];
//map of profession_id -> primary_attribute_id
const PROF_PRI_ATTR_MAP  = {0: -1, 1: 17, 2: 23, 3: 16, 4: 6, 5: 0, 6: 12, 7: 35, 8: 36, 9: 40, 10: 44};
const PROF_FN_NAME = {
	0:'none', 1:'warrior', 2:'ranger', 3:'monk', 4:'necromancer', 5:'mesmer',
	6:'elementalist', 7:'assassin', 8:'ritualist', 9:'paragon', 10:'dervish'
};
const SKILLTYPES_EXTRAICONS = [5,6,7,23,24,27];
const ATTRIBUTE_MAP = {
	'-9': {prof: 0,  name: {de: 'Norntitel', en: 'Norn Title Track'}},
	'-8': {prof: 0,  name: {de: 'Ebon-Vorhut-Titel', en: 'Ebon Vanguard Title Track'}},
	'-7': {prof: 0,  name: {de: 'Deldrimortitel', en: 'Deldrimor Title Track'}},
	'-6': {prof: 0,  name: {de: 'Asuratitel', en: 'Asura Title Track'}},
	'-5': {prof: 0,  name: {de: 'Freund der Kurzick', en: 'Friend of the Kurzicks Title Track'}},
	'-4': {prof: 0,  name: {de: 'Freund der Luxon', en: 'Friend of the Luxons Title Track'}},
	'-3': {prof: 0,  name: {de: 'Lichtbringertitel', en: 'Lightbringer Title Track'}},
	'-2': {prof: 0,  name: {de: 'Sonnenspeertitel', en: 'Sunspear Title Track'}},
	'-1': {prof: 0,  name: {de: 'Kein Attribut', en: 'No Attribute'}},
	'0' : {prof: 5,  name: {de: 'Schnellwirkung', en: 'Fast Casting'}},
	'1' : {prof: 5,  name: {de: 'Illusionsmagie', en: 'Illusion Magic'}},
	'2' : {prof: 5,  name: {de: 'Beherrschungsmagie', en: 'Domination Magic'}},
	'3' : {prof: 5,  name: {de: 'Inspirationsmagie', en: 'Inspiration Magic'}},
	'4' : {prof: 4,  name: {de: 'Blutmagie', en: 'Blood Magic'}},
	'5' : {prof: 4,  name: {de: 'Todesmagie', en: 'Death Magic'}},
	'6' : {prof: 4,  name: {de: 'Seelensammlung', en: 'Soul Reaping'}},
	'7' : {prof: 4,  name: {de: 'Flüche', en: 'Curses'}},
	'8' : {prof: 6,  name: {de: 'Luftmagie', en: 'Air Magic'}},
	'9' : {prof: 6,  name: {de: 'Erdmagie', en: 'Earth Magic'}},
	'10': {prof: 6,  name: {de: 'Feuermagie', en: 'Fire Magic'}},
	'11': {prof: 6,  name: {de: 'Wassermagie', en: 'Water Magic'}},
	'12': {prof: 6,  name: {de: 'Energiespeicherung', en: 'Energy Storage'}},
	'13': {prof: 3,  name: {de: 'Heilgebete', en: 'Healing Prayers'}},
	'14': {prof: 3,  name: {de: 'Peinigungsgebete', en: 'Smiting Prayers'}},
	'15': {prof: 3,  name: {de: 'Schutzgebete', en: 'Protection Prayers'}},
	'16': {prof: 3,  name: {de: 'Gunst der Götter', en: 'Divine Favor'}},
	'17': {prof: 1,  name: {de: 'Stärke', en: 'Strength'}},
	'18': {prof: 1,  name: {de: 'Axtbeherrschung', en: 'Axe Mastery'}},
	'19': {prof: 1,  name: {de: 'Hammerbeherrschung', en: 'Hammer Mastery'}},
	'20': {prof: 1,  name: {de: 'Schwertkunst', en: 'Swordsmanship'}},
	'21': {prof: 1,  name: {de: 'Taktik', en: 'Tactics'}},
	'22': {prof: 2,  name: {de: 'Tierbeherrschung', en: 'Beast Mastery'}},
	'23': {prof: 2,  name: {de: 'Fachkenntnis', en: 'Expertise'}},
	'24': {prof: 2,  name: {de: 'Überleben in der Wildnis', en: 'Wilderness Survival'}},
	'25': {prof: 2,  name: {de: 'Treffsicherheit', en: 'Marksmanship'}},
	'29': {prof: 7,  name: {de: 'Dolchbeherrschung', en: 'Dagger Mastery'}},
	'30': {prof: 7,  name: {de: 'Tödliche Künste', en: 'Deadly Arts'}},
	'31': {prof: 7,  name: {de: 'Schattenkünste', en: 'Shadow Arts'}},
	'32': {prof: 8,  name: {de: 'Zwiesprache', en: 'Communing'}},
	'33': {prof: 8,  name: {de: 'Wiederherstellungsmagie', en: 'Restoration Magic'}},
	'34': {prof: 8,  name: {de: 'Kanalisierungsmagie', en: 'Channeling Magic'}},
	'35': {prof: 7,  name: {de: 'Kritische Stöße', en: 'Critical Strikes'}},
	'36': {prof: 8,  name: {de: 'Macht des Herbeirufens', en: 'Spawning Power'}},
	'37': {prof: 9,  name: {de: 'Speerbeherrschung', en: 'Spear Mastery'}},
	'38': {prof: 9,  name: {de: 'Befehlsgewalt', en: 'Command'}},
	'39': {prof: 9,  name: {de: 'Motivation', en: 'Motivation'}},
	'40': {prof: 9,  name: {de: 'Führung', en: 'Leadership'}},
	'41': {prof: 10, name: {de: 'Sensenbeherrschung', en: 'Scythe Mastery'}},
	'42': {prof: 10, name: {de: 'Windgebete', en: 'Wind Prayers'}},
	'43': {prof: 10, name: {de: 'Erdgebete', en: 'Earth Prayers'}},
	'44': {prof: 10, name: {de: 'Mystik', en: 'Mysticism'}},
};

// map of skilltypes affected by primary attributes
const SKILL_A_EXPERTISE  = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 17, 18, 19, 30, 31, 32];
const SKILL_A_FASTCAST   = [22, 23, 24, 25, 26, 27, 28];
const SKILL_A_FASTCAST_R = [22, 23, 24];
const SKILL_A_SPAWNING   = [18, 19, 32];
const SKILL_A_LEADERSHIP = [13, 20];
const SKILL_A_MYSTICISM  = [23, 33];
const SKILL_A_STRENGTH   = [2, 3, 4, 5, 6, 7, 8, 9, 10, 12];

// spawning power skill fixtures
const SKILL_FIX_SPAWNING = [787, 792, 793, 795, 964, 983, 1257, 1258, 1267, 1749, 1750, 1752, 2148, 2149, 2219];

// minion skills -> spawning power
const SKILLS_MINION = [83, 84, 85, 114, 122, 805, 832, 1351, 1355];

// touch skills -> expertise
const SKILLS_TOUCH = [
	29, 58, 154, 155, 156, 157, 158, 231, 232, 312, 313, 314, 424, 525, 786, 801, 918, 990, 1009, 1045, 1059,
	1077, 1078, 1079, 1095, 1131, 1146, 1155, 1263, 1328, 1401, 1406, 1439, 1447, 1528, 1534, 1545, 1619, 1645,
	1818, 1862, 1894, 2011, 2080, 2081, 2088, 2114, 2129, 2213, 2214, 2215, 2244, 2357, 2375, 2376, 2380, 2385,
	2492, 2501, 2506
];

// divine favor, additional healing
const SKILLS_DF_ADD = [281, 282, 283, 286, 313, 867, 941, 958, 959, 1120, 1121, 1396, 1686, 1687, 2062];

// divine favor, self targeted
const SKILLS_DF_SELF = [
	247, 256, 257, 265, 268, 271, 279, 280, 284, 287, 298, 304, 310, 943, 957, 960, 1113, 1117, 1118, 1119,
	1262, 1393, 1394, 1397, 1684, 1685, 1952, 2005, 2095, 2105, 2857, 2871, 2890
];

// divine favor, target gains health
const SKILLS_DF_TARGET = [
	241, 242, 243, 244, 245, 246, 248, 249, 250, 254, 255, 258, 259, 260, 261, 262, 263, 266, 267, 269, 270,
	272, 273, 274, 275, 276, 277, 278, 285, 288, 289, 290, 291, 292, 299, 301, 302, 303, 307, 308, 309, 311,
	838, 848, 885, 886, 942, 991, 1114, 1115, 1123, 1126, 1390, 1391, 1392, 1395, 1399, 1400, 1401, 1683,
	1691, 1692, 2003, 2004, 2007, 2061, 2063, 2064, 2065, 2887
];

const DESC_ADDITIONAL = {
	warrior: {
		self:{
			de: 'Diese Angriffsfertigkeit hat +{VAL}% Rüstungsdurchdringung.',
			en: 'This attack skill has +{VAL}% armor penetration.',
		},
		other:{
			de: 'Angriffsfertigkeiten haben +{VAL}% Rüstungsdurchdringung.',
			en: 'Attack skills have +{VAL}% armor penetration.',
		}
	},
	ranger: {
		self:{
			de: 'Diese Fertigkeit kostet {VAL}% weniger Energie.',
			en: 'This skill costs {VAL}% less energy.',
		},
		other:{
			de: 'Waldläufer-, Angriffs- und Berührungsfertigkeiten, sowie Rituale kosten {VAL}% weniger Energie.',
			en: 'Ranger skills, attack skills, touch skills and rituals cost {VAL}% less energy.',
		}
	},
	monk:{
		target:{
			de: 'Das Ziel erhält {VAL} Lebenspunkte.',
			en: 'Target ally gains {VAL} health.',
		},
		add:{
			de: 'Das Ziel erhält zusätzlich {VAL} Lebenspunkte.',
			en: 'Target ally gains an additional {VAL} health.',
		},
		self:{
			de: 'Ihr erhaltet {VAL} Lebenspunkte.',
			en: 'You gain {VAL} health.',
		},
		other:{
			de: 'Mönch-Zauber geben {VAL} Lebenspunkte.',
			en: 'Monk spells give {VAL} health.',
		},
	},
	necromancer:{
		self:{
			de: 'Jedesmal, wenn eine Kreatur stirbt, die kein Geist ist, erhaltet Ihr {VAL} Energie (max. 3x in 15s).',
			en: 'Whenever a non-spirit creature dies, You gain {VAL} energy (max. 3x in 15s).',
		},
	},
	mesmer: {
		spell1:{
			de: 'Dieser Zauber hat noch {VAL1}% seiner Aktivierungszeit und {VAL2}% seiner Aufladezeit im PvE.',
			en: 'This spell has {VAL1}% of its base activation time and {VAL2}% recharge in PvE.',
		},
		spell2:{
			de: 'Dieser Zauber hat noch {VAL}% seiner Aktivierungszeit.',
			en: 'This spell has {VAL}% of its base activation time.',
		},
		spell3:{
			de: 'Zauber haben noch {VAL1}%, Siegel {VAL2}% ihrer Aktivierungszeit (Nicht-Mesmer-Fertigkeiten ab 2 Sekunden Aktivierung). Mesmer-Zauber haben im PvE noch {VAL2}% ihrer Aufladezeit.',
			en: 'Spells have {VAL1}%, signets {VAL2}% of their activation time (non Mesmer skills with activation of 2 seconds or greater). Mesmer spells have {VAL2}% of their recharge time in PvE.',

		},
		signet1:{
			de: 'Dieses Siegel hat noch {VAL}% seiner Aktivierungszeit und benutzt das Schnellwirkungs-Attribut wenn Symbolische Schnelligkeit aktiv ist.',
			en: 'This signet has {VAL}% of its base activation time and uses the Fast Casting attribute if Symbolic Celerity is active.',
		},
		signet2:{
			de: 'Dieses Siegel hat noch {VAL}% seiner Aktivierungszeit.',
			en: 'This signet has {VAL}% of its base activation time.',
		},
		signet3:{
			de: 'Dieses Siegel benutzt das Schnellwirkungs-Attribut wenn Symbolische Schnelligkeit aktiv ist.',
			en: 'This signet uses the Fast Casting attribute if Symbolic Celerity is active.',
		},
	},
	elementalist:{
		self:{
			de: 'Eure maximalen Energiepunkte erhöhen sich um +{VAL}.',
			en: 'You gain +{VAL} maximum energy.',
		},
	},
	ritualist: {
		weaponspell: {
			de: 'Dieser Waffenzauber hält {VAL}% länger an.',
			en: 'This weapon spell lasts {VAL}% longer.',
		},
		creature: {
			de: 'Diese Kreatur hat +{VAL}% maximale Lebenspunkte.',
			en: 'This creature has +{VAL}% maximum health.',
		},
		other: {
			de: 'Belebte Kreaturen haben +{VAL}% maximale Lebenspunkte und Waffenzauber halten {VAL}% länger an.',
			en: 'Animated creatures have +{VAL}% maximum health and weapons spells last {VAL}% longer.',
		},
	},
	assassin:{
		self:{
			de: 'Die Chance auf kritische Treffer ist um {VAL1}% erhöht. Ihr erhaltet {VAL2} Energie für jeden kritischen Treffer.',
			en: 'Critical hit chance is increased by {VAL1}%. You gain {VAL2} energy for each critical hit.',
		},
	},
	paragon: {
		self:{
			de: 'Ihr erhaltet 2 Energiepunkte für jeden von dieser Fertigkeit betroffenen Verbündeten (max. {VAL}).',
			en: 'You gain 2 energy for each ally affected by this skill (max. {VAL}).',
		},
		other:{
			de: 'Ihr erhaltet 2 Energiepunkte für jeden von Euren Anfeuerungsrufen und Schreien betroffenen Verbündeten (max. {VAL}).',
			en: 'You gain 2 energy for each ally affected by your chants and shouts (max. {VAL}).',
		}
	},
	dervish: {
		self:{
			de: 'Diese Fertigkeit kostet {VAL1}% weniger Energie und Ihr habt +{VAL2} Rüstung, während Ihr verzaubert seid.',
			en: 'This skill costs {VAL1}% less energy and you gain +{VAL2} armor while enchanted.',
		},
		other:{
			de: 'Derwisch-Verzauberungen kosten {VAL1}% weniger Energie und Ihr habt +{VAL2} Rüstung, während Ihr verzaubert seid.',
			en: 'Dervish Enchantments cost {VAL1}% less energy and you gain +{VAL2} armor while enchanted.',
		}
	},
	creature: {
		spawning:{
			de: 'Diese Kreatur hat {VAL3} ({VAL1}) Lebenspunkte und {VAL2} Rüstung.',
			en: 'This creature has {VAL3} ({VAL1}) health and {VAL2} armor.',
		},
		other:{
			de: 'Diese Kreatur hat {VAL1} Lebenspunkte und {VAL2} Rüstung.',
			en: 'This creature has {VAL1} health and {VAL2} armor.',
		},
	}
};

class Helpers {

	static extend(target, source){

		for(let property in source){
			if(source.hasOwnProperty(property)){
				target[property] = source[property];
			}
		}

		return target;
	}

	static in_array(needle, haystack){

		for(let key in haystack){
			if(haystack.hasOwnProperty(key)){
				if(haystack[key] === needle){
					return true;
				}
			}
		}

		return false;
	}

	// https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding
	static encodeUTF8string(str){
		return encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (match, p1) => {
				return String.fromCharCode('0x' + p1);
			});
	}

	// http://locutus.io/php/base64_encode/
	static base64_encode(str){

		if(typeof window.btoa !== 'undefined'){
			return window.btoa(Helpers.encodeUTF8string(str));
		}

		let b64    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
		let i      = 0;
		let ac     = 0;
		let tmpArr = [];
		let o1, o2, o3, h1, h2, h3, h4, bits;

		if(!str){
			return '';
		}

		str = Helpers.encodeUTF8string(str);

		do{
			// pack three octets into four hexets
			o1 = str.charCodeAt(i++);
			o2 = str.charCodeAt(i++);
			o3 = str.charCodeAt(i++);

			bits = o1 << 16|o2 << 8|o3;

			h1 = bits >> 18&0x3f;
			h2 = bits >> 12&0x3f;
			h3 = bits >> 6&0x3f;
			h4 = bits&0x3f;

			// use hexets to index into b64, and append result to encoded string
			tmpArr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
		}
		while(i < str.length);

		let enc = tmpArr.join('');
		let r   = str.length % 3;

		return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
	}

}

class Tooltip{

	/**
	 * @param options
	 */
	constructor(options){

		this.options = Helpers.extend({
			targetSelector     : '.tooltip',
			tooltipID          : 'tooltip-container',
			cacheContainerClass: 'tooltip-cache',
			mouseOffsetX       : 15,
			mouseOffsetY       : 15,
			enableFadeIn       : true,
			fadeTimeout        : 250,
		}, options);

	}

	/**
	 * @returns {Tooltip}
	 */
	init(){
		// create a tooltip element
		this.tooltip = document.createElement('div');

		this.tooltip.id              = this.options.tooltipID;
		this.tooltip.style.position  = 'absolute';
		this.tooltip.style.top       = '0px';
		this.tooltip.style.left      = '-100000px';
		this.tooltip.style.display   = 'none';
		this.tooltip.style.transform = 'translate3d(0px, 0px, 0px)';

		document.body.appendChild(this.tooltip);

		// prepare the listeners
		document.querySelectorAll(this.options.targetSelector).forEach(e =>{

			if(typeof e.dataset.id === 'undefined' || e.dataset.id === ''){
				return;
			}

			// an invisible container for the generated tooltip html as cache
			let c = document.createElement('div');

			c.className  = this.options.cacheContainerClass;
			c.dataset.id = e.dataset.id;

			e.parentNode.insertBefore(c, e);

			e.addEventListener('mouseenter', ev => this.mouseEnter(e, ev, c));
//			e.addEventListener('mouseover', ev => this.pos(e, ev, c));
			e.addEventListener('mousemove', ev => this.pos(e, ev, c));
			e.addEventListener('mouseout', () => {

				if(this.options.enableFadeIn){
					this.tooltip.style.opacity = 0;
				}

				this.tooltip.style.display = 'none';
				this.tooltip.style.left    = '-100000px';
				this.tooltip.innerHTML     = '';
				this.tooltipLoaded         = false;
			});

		});

		return this;
	}

	/**
	 * @param e
	 * @param ev
	 * @param c
	 */
	pos(e, ev, c){

		// content is loaded and we're still on the same event target
		if(this.tooltipLoaded){
			let left = window.scrollX + ev.clientX + this.options.mouseOffsetX;
			let top  = window.scrollY + ev.clientY + this.options.mouseOffsetY;

			if(this.tooltip.offsetHeight + ev.clientY + this.options.mouseOffsetY+this.tooltip.style.borderWidth > window.innerHeight){
				top -= this.tooltip.offsetHeight + 2*this.options.mouseOffsetY;
			}

			if(this.tooltip.offsetWidth + ev.clientX + 2*this.options.mouseOffsetX + 5 > window.innerWidth){ // borderWidth doesn't work here wtf?
				left -= this.tooltip.offsetWidth + 2*this.options.mouseOffsetX;
			}

			this.tooltip.style.transform = 'translate3d('+left+'px, '+top+'px, 0px)';

			return;
		}

		// no content? try again!
		this.mouseEnter(e, ev, c);
	}

	/**
	 * @param e
	 * @param ev
	 * @param c
	 */
	mouseEnter(e, ev, c){
		this.tooltipLoaded = false;

		// there's already content in the hidden container
		if(c && c.className === this.options.cacheContainerClass && c.innerHTML !== ''){
			this.tooltip.innerHTML = c.innerHTML;
			this.tooltipLoaded     = true;

			this.pos(e, ev);

			if(this.options.enableFadeIn){
				this.fadeIn();
			}
			else{
				this.tooltip.style.left    = '0px';
				this.tooltip.style.display = 'inline-block';
			}

			return true;
		}

		// load data here
		return false;
	}

	/**
	 * https://stackoverflow.com/a/20533102
	 */
	fadeIn(){
		this.tooltip.style.left    = '0px';
		this.tooltip.style.opacity = 0;
		this.tooltip.style.filter  = 'alpha(opacity=0)';
		this.tooltip.style.display = 'inline-block';

		let opacity = 0;
		let timer = setInterval(() =>{
			opacity += 50 / this.options.fadeTimeout;
			if(opacity >= 1){
				clearInterval(timer);
				opacity = 1;
			}
			this.tooltip.style.opacity = opacity;
			this.tooltip.style.filter  = 'alpha(opacity=' + opacity * 100 + ')';
		}, 50);
	}

}

// THERE BE DRAGONS
class GWTooltip extends Tooltip{

	constructor(options){

		options = Helpers.extend({
			gwdbURL            : './gwdb',
			targetSelector     : '.gwbb-skill', // needs "skill" in the name for match()
			tooltipID          : 'gwbb-tooltip',
			cacheContainerClass: 'gwbb-tooltip-cache',
			lang               : 'en',
			imgExt: '.png',
			imgMiscPath: '/img/misc',
			jsonExt: '.json',
			jsonSkillPath:'/json/skills', // relative to gwdbURL
		}, options);

		super(options);
	}

	/**
	 * @param e
	 * @param ev
	 * @param c
	 */
	mouseEnter(e, ev, c){

		if(!super.mouseEnter(e, ev, c)){
			this.fetchData(e, ev, c);
		}

	}

	/**
	 * @param json
	 * @param e
	 * @param ev
	 * @param c
	 * @returns {*}
	 */
	setData(json, e, ev, c){

		// there's a container element attached - fill it
		if(c && c.className === this.options.cacheContainerClass){
			let pvp  = (e.dataset.pvp || e.parentElement.dataset.pvp) === '1';
			let lang = e.parentElement.dataset.lang || e.dataset.lang;

			lang = Helpers.in_array(lang, LANGUAGES) ? lang : this.options.lang;

			// skill tooltips
			if(e.className.match(/skill/)){
				let a         = e.dataset.attr || e.parentElement.dataset.attr || false;
				let extraAttr = e.parentElement.dataset.xattr || false;
				let pri       = parseInt(e.parentElement.dataset.pri || json.profession);
				let sec       = parseInt(e.parentElement.dataset.sec || 0);
				let attr      = {};

				// parse the attributes
				if(a){
					a.split(',').forEach(s => {
						s = s.split(':');
						attr[parseInt(s[0])] = Math.min(21, Math.max(0, parseInt(s[1])));
					});
				}

				// bonus attribute skills
				if(extraAttr){
					extraAttr = extraAttr.split(',').map(x => parseInt(x));
				}

				// fill the tooltip
				c.innerHTML = this.skillTooltip(pri, sec, pvp, attr, extraAttr, json, lang);

				this.tooltip.innerHTML = c.innerHTML;
			}
		}

		// reload
		this.mouseEnter(e, ev, c);

		// return the json data for the fetch promise -> to localstorage
		return json;
	}

	/**
	 * @param e
	 * @param ev
	 * @param c
	 */
	fetchData(e, ev, c){

		// go along, nothing to see here.
		if(typeof e.dataset.id === 'undefined' || e.dataset.id === '' || !c){
			return;
		}

		let type;

		// decide what to load
		if(e.className.match(/skill/)){
			type = {jsonpath:this.options.jsonSkillPath, storage:'skilldata'}
		}

		if(!type){
			return;
		}

		// try to fetch from localstorage
		let data = localStorage.getItem(type.storage+'-' + e.dataset.id);

		if(data){
			data = JSON.parse(data);

			if(typeof data.id === 'number' && data.id >= 0){
				e.dataset.dataFetched = 'true';

				this.setData(data, e, ev, c);

				console.log('loaded '+type.storage+' from localstorage: #'+data.id, c);
				return;
			}

		}

		// wait for the fetch promise to resolve
		if((e.dataset.dataFetched && e.dataset.dataFetched === 'false')){
			return;
		}

		// fetch otherwise
		e.dataset.dataFetched = 'false';

		fetch(this.options.gwdbURL + type.jsonpath + '/' + e.dataset.id + this.options.jsonExt, {mode: 'cors'})
			.then(r =>{
				if(r.status === 200){
					return r;
				}

				throw new Error(r.statusText);
			})
			.then(r => r.json())
			.then(json => this.setData(json, e, ev, c))
			.then(json => {
				localStorage.setItem(type.storage+'-'+ json.id, JSON.stringify(json));
				console.log('fetched '+type.storage+': #'+json.id, c);
				e.dataset.dataFetched = 'true';
			})
			.catch(error => console.log('(╯°□°）╯彡┻━┻ ', error));

	}

	/**
	 * @param pri
	 * @param sec
	 * @param pvp
	 * @param attr
	 * @param extraAttr
	 * @param skilldata
	 * @param lang
	 * @returns {string}
	 */
	skillTooltip(pri, sec, pvp, attr, extraAttr, skilldata, lang){

		let stats      = skilldata[pvp && skilldata.split === true ? 'pvp' : 'pve'];
		let desc       = new GWSkillDescription(skilldata, pri, sec, pvp, attr, extraAttr, lang);
		let cssClass   = skilldata.profession_name.en.toLowerCase();
		let imgCss     = cssClass + (skilldata.elite === true ? ' elite' : '');
		let attrEffect = attr[skilldata.attribute] > 0 ? desc.effectText(attr[skilldata.attribute]) + ' ' : '';
		let skilldesc  = desc.description();
		let p          = Object.keys(skilldesc.prog);
		let statIcons  = '';
		let imgExtra   = '';
		let tbl        = '';
		let i;

		let statsData = {
			sacrifice: stats.sacrifice > 0 ? stats.sacrifice + '%' : false,
			overcast: stats.overcast > 0 ? stats.overcast : false,
			upkeep: stats.upkeep < 0 ? stats.upkeep : false,
			energy: desc.energy(),
			adrenaline: stats.adrenaline > 0 ? stats.adrenaline : false,
			activation: desc.activation(),
			recharge: desc.recharge(),
		};

		// icons: energy, activation etc.
		Object.keys(statsData).forEach(k => {

			if(!statsData[k]){
				return;
			}

			statIcons += ` ${statsData[k]}<img src="${this.options.gwdbURL+this.options.imgMiscPath}/${k+this.options.imgExt}" />`;
		});

		// skill progression table
		if(p.length){

			for(i = 0; i < 22; i++){
				tbl += `<th>${i}</th>`;
			}

			tbl = `<div class="gwbb-tooltip-progression"><table><tr>${tbl}</tr>`;

			p.forEach(k =>{
				tbl += `<tr>${skilldesc.prog[k]}</tr>`;
			});

			tbl += '</table></div>';
		}

		// additional skill type icon for enchantments, hex, etc.
		if(Helpers.in_array(stats.type, SKILLTYPES_EXTRAICONS)){
			imgExtra = `<img class="gwbb-tooltip-img-extra" src="${this.options.gwdbURL+this.options.imgMiscPath}/s${stats.type+this.options.imgExt}" alt="">`;
		}

		return `<div class="gwbb-tooltip-inner ${cssClass}">
					<div class="gwbb-tooltip-skill-img">
						<div class="gwbb-skill ${imgCss}">
							<div class=" gwbb-tooltip-img" style="background-image: url(${skilldata.image})">${imgExtra}</div>
						</div>
					</div>
					<div class="gwbb-tooltip-skill-desc">
						<h1 class="${cssClass}"><span>${statIcons}</span>${stats.name[lang]}</h1>
						<h2>${attrEffect}${ATTRIBUTE_MAP[skilldata.attribute].name[lang]}</h2>
						<p>${skilldesc.desc}</p>
						<!--<p>${skilldesc.concise}</p>-->
						${skilldesc.additional}
					</div>
					${tbl}
					<div class="gwbb-tooltip-footer">
						<span style="float: right">${skilldata.campaign_name} #${skilldata.id}</span>
						${stats.name[lang === 'en' ? 'de' : 'en']}
					</div>
				</div>`;
	}

}

class GWSkillDescription{

	/**
	 * @param skilldata
	 * @param pri
	 * @param sec
	 * @param pvp
	 * @param extraAttr
	 * @param attr
	 * @param lang
	 */
	constructor(skilldata, pri, sec, pvp, attr, extraAttr, lang){
		this.data      = skilldata;
		this.pri       = parseInt(pri) || 0;
		this.sec       = parseInt(sec) || 0;
		this.pvp       = pvp;
		this.attr      = attr;
		this.extraAttr = extraAttr;
		this.lang      = lang;

		this.id               = skilldata.id;
		this.stats            = skilldata[pvp && skilldata.split === true ? 'pvp' : 'pve'];
		this.val              = parseInt(this.attr[this.data.attribute]) || 0;
		this.pri_val          = parseInt(this.attr[PROF_PRI_ATTR_MAP[this.pri]]) || 0;
	}

	/**
	 * @returns {*}
	 */
	energy(){

		if(!this.stats.energy){
			return false;
		}

		if(!Helpers.in_array(this.pri, [2, 10]) || !this.pri_val){
			return this.stats.energy;
		}

		let energy = Math.round(this.stats.energy * (1 - 0.04 * this.pri_val));

		if(this.pri === 2 && (
			this.data.profession === 2
			|| Helpers.in_array(this.stats.type, SKILL_A_EXPERTISE)
			|| Helpers.in_array(this.id, SKILLS_TOUCH)
		)){
			return `<span class="ranger">${energy}</span> (${this.stats.energy})`;
		}

		if(this.pri === 10 && Helpers.in_array(this.stats.type, SKILL_A_MYSTICISM)){
			return `<span class="dervish">${energy}</span> (${this.stats.energy})`;
		}

		return this.stats.energy;
	}

	/**
	 * @returns {*}
	 */
	activation(){

		if(!this.stats.activation){
			return false;
		}

		// mesmer only
		if(this.pri === 5 && this.pri_val){

			if((this.stats.type === 21
			    || Helpers.in_array(this.stats.type, SKILL_A_FASTCAST))
				&& (this.data.profession === 5 || this.stats.activation >= 2)
			){
				let activation = this.stats.type === 21
					// signet
					? this.stats.activation * (1 - (this.pri_val * 0.03))
					// spells
					: this.stats.activation * Math.pow(2, -this.pri_val / 15);

				if(activation){
					return `<span class="mesmer">${activation.toFixed(2)}</span> (${this.stats.activation_str})`;
				}
			}
		}

		return this.stats.activation_str;
	}

	/**
	 * @returns {*}
	 */
	recharge(){

		if(!this.stats.recharge){
			return false;
		}

		// mesmer, pve only
		if(!this.pvp && this.pri === 5 && this.pri_val > 0 && this.data.profession === 5
		   && Helpers.in_array(this.stats.type, SKILL_A_FASTCAST_R)
		){
			let recharge = this.stats.recharge * (1 - this.pri_val * 0.03);

			return `<span class="mesmer">${recharge.toFixed(2)}</span> (${this.stats.recharge})`;
		}

		return this.stats.recharge;
	}

	/**
	 * @returns {{desc: string, concise: string, additional: string, prog: {}}}
	 */
	description(){
		this.prog_val = {};
		let desc       = this.stats.desc[this.lang];
		let concise    = this.stats.concise[this.lang];
		let additional = '';

		// skill progression, first pass
		let p1 = /(?:(stufe|level) )?(\d+)[.]{2,3}(\d+)(?: (seconds?|sekunden?))?/ig;
		let r1 = (match, p1, val0, val15, p2) => this.progressionReplace1(match, p1, val0, val15, p2);

		desc    = desc.replace(p1, r1);
		concise = concise.replace(p1, r1);

		// skill progression, second pass - weapon duration for non-progression values
		if(this.stats.type === 27 && this.pri === 8 && this.pri_val){

			let p2 = /(\d+) (seconds?|sekunden?)/i;
			let r2 = (match, val, p1) => this.progressionReplace2(match, val, p1);

			desc    = desc.replace(p2, r2);
			concise = concise.replace(p2, r2);
		}

		// additional creature health
		if(Helpers.in_array(this.stats.type, SKILL_A_SPAWNING) || Helpers.in_array(this.id, SKILLS_MINION) || this.id === 1239){
			additional += this.creature();
		}

		// additional primary attribute effect
		if(this.pri && this.pri_val){
			additional += `
				<h2>${this.effectText(this.pri_val)} ${ATTRIBUTE_MAP[PROF_PRI_ATTR_MAP[this.pri]].name[this.lang]}</h2>
				<p class="${PROF_FN_NAME[this.pri]}">${this[PROF_FN_NAME[this.pri]]()}</p>`;
		}

		return {
			desc: '<em>' + this.stats.type_name[this.lang] + '</em>: ' + desc,
			concise: '<em>' + this.stats.type_name[this.lang] + '</em>: ' + concise,
			additional: additional,
			prog: this.prog_val,
		}
	}

	/**
	 * @param val0
	 * @param val15
	 * @param attr_val
	 * @returns {number}
	 */
	progression(val0, val15, attr_val){
		val0  = parseInt(val0);
		val15 = parseInt(val15);

		let value = (val15 - val0) / 15;

		switch(true){
			case Helpers.in_array(this.data.attribute, [-5, -4]): // Lux/Kurz
				value = value * (attr_val + Math.floor(attr_val / 4));
				break;
			case Helpers.in_array(this.data.attribute, [-9, -8, -7, -6]): // EOTN titles
				value = value * (attr_val + Math.floor(attr_val / 2));
				break;
			default:
				value = value * attr_val;
		}

		return Math.round(value) + val0;
	}

	/**
	 * @param val
	 * @returns {string}
	 */
	effectText(val){
		return '<span class="effect">' + val + '</span>';
	}

	/**
	 * @param duration
	 * @returns {number}
	 */
	weaponDuration(duration){
		return Math.round(duration * (1 + this.pri_val * 0.04));
	}

	/**
	 * @param match
	 * @param p1
	 * @param val0
	 * @param val15
	 * @param p2
	 * @returns {string}
	 */
	progressionReplace1(match, p1, val0, val15, p2){
		let effect = this.progression(val0, val15, this.val);
		let prog = '';
		let i;
		let scCheck = this.pri === 5 && Helpers.in_array(1340, this.extraAttr) && this.stats.type === 21 && this.id !== 63;

		// collect the progression levels for the table
		for(i = 0; i < 22; i++){
			let c = i === this.pri_val && scCheck;
			// todo: other bonus attribute skills
			c = i === this.val || c ? (c ? 'mesmer' : 'effect') + ' highlight' : ' none';

			prog += `<td class="${c}">${this.progression(val0, val15, i)}</td>`;
		}

		this.prog_val[[val0, val15].join('-')] = prog;

		// fast casting -> symbolic celerity effect
		if(this.pri_val && scCheck){
			let val = this.progression(val0, val15, this.pri_val);
			effect  = this.effectText((this.val ? effect : val0));

			return `<span class="mesmer">${val}</span> (${effect}) ` + (p2 ? ' '+p2 : '');
		}

		// spawning power -> weapon spell duration
		if(this.pri === 8 && this.pri_val
			// sundering weapon fix
			&& !(this.id === 2148 && val15 === '20')
		){

			if(this.stats.type === 27 && this.val){
				let text = `<span class="ritualist">${this.weaponDuration(effect)}</span> (${this.effectText(effect)})`;

				if(Helpers.in_array(this.id, SKILL_FIX_SPAWNING)){

					if(p2 && p2.match(/(seconds?|sekunden?)/i)){
						return text + ' ' + p2;
					}

					return this.effectText(effect);
				}

				return text + (p2 ? ' ' + p2 + ' ' : '');
			}
		}

		// fetch the creature level (if any)
		if(Helpers.in_array(this.stats.type, SKILL_A_SPAWNING) || Helpers.in_array(this.id, SKILLS_MINION) || this.id === 1239){
			if(p1 && p1.match(/(stufe|level)/i)){
				this.creatureLevel = effect;
			}
		}

		return (p1 ? p1+' ' : '') +this.effectText(this.val ? effect : val0 + '...' + val15) + (p2 ? ' '+p2 : '') ;
	}

	/**
	 * @param match
	 * @param val
	 * @param p1
	 * @returns {*}
	 */
	progressionReplace2(match, val, p1){

		if(this.stats.type === 27 && this.pri === 8 && this.pri_val && this.id !== 983){
			return `<span class="ritualist">${this.weaponDuration(val)}</span> (${val}) ` + p1;
		}

		return match;
	}

	/**
	 * @returns {string}
	 */
	creature(){
		let health = this.creatureLevel * 20;
		let armor = 6 * this.creatureLevel + 3;
		let spHealth, d;

		// wonky guildwiki armor/level values - no guarantee
		if(Helpers.in_array(this.id, SKILLS_MINION)){
			health += 80;
			armor = 3.75 * this.creatureLevel + 5;

			switch(this.id){
				case 84: armor = 2.84 * this.creatureLevel + 3.1; break;
				case 85: armor = 2.9 * this.creatureLevel + 1.25; break;
			}
		}

		if(this.pri === 8 && this.pri_val){
			spHealth = health * (1 + this.pri_val * 0.04);
			d = DESC_ADDITIONAL.creature.spawning[this.lang]
		}
		else{
			d = DESC_ADDITIONAL.creature.other[this.lang]
		}

		d = d
			.replace(/{VAL1}/, this.effectText(Math.round(health)))
			.replace(/{VAL2}/, this.effectText(Math.round(armor)))
			.replace(/{VAL3}/, `<span class="ritualist">${Math.round(spHealth)}</span>`);

		return '<p>' + d + '</p>';
	}

	/**
	 * Warrior -> Strength
	 *
	 * @returns {string}
	 */
	warrior(){
		let d = Helpers.in_array(this.stats.type, SKILL_A_STRENGTH)
			? DESC_ADDITIONAL.warrior.self[this.lang]
			: DESC_ADDITIONAL.warrior.other[this.lang];

		return d.replace(/{VAL}/, this.effectText(this.pri_val));
	}

	/**
	 * Ranger -> Expertise
	 *
	 * @returns {string}
	 */
	ranger(){
		let d = this.stats.energy && (
			this.data.profession === 2
			|| Helpers.in_array(this.stats.type, SKILL_A_EXPERTISE)
			|| Helpers.in_array(this.id, SKILLS_TOUCH)
		)
				? DESC_ADDITIONAL.ranger.self[this.lang]
				: DESC_ADDITIONAL.ranger.other[this.lang];

		return d.replace(/{VAL}/, this.effectText(this.pri_val * 4));
	}

	/**
	 * Monk -> Divine favor
	 *
	 * @returns {string}
	 */
	monk(){
		let d;

		if(Helpers.in_array(this.id, SKILLS_DF_TARGET)){
			d = DESC_ADDITIONAL.monk.target[this.lang]
		}
		else if(Helpers.in_array(this.id, SKILLS_DF_ADD)){
			d = DESC_ADDITIONAL.monk.add[this.lang]
		}
		else if(Helpers.in_array(this.id, SKILLS_DF_SELF)){
			d = DESC_ADDITIONAL.monk.self[this.lang]
		}
		else{
			d = DESC_ADDITIONAL.monk.other[this.lang]
		}

		return d.replace(/{VAL}/, this.effectText(Math.round(3.2 * this.pri_val)));
	}

	/**
	 * Necromancer -> Soul reaping
	 *
	 * @returns {string}
	 */
	necromancer(){
		return DESC_ADDITIONAL.necromancer.self[this.lang].replace(/{VAL}/, this.effectText(this.pri_val));
	}

	/**
	 * Mesmer -> Fast casting
	 *
	 * @returns {string}
	 */
	mesmer(){
		let calc1 = Math.round(100 * (1 - (this.pri_val * 0.03))); // signet activation and spell recharge
		let calc2 = Math.round(100 * Math.pow(2, ((this.pri_val * -1) / 15))); // spell activation
		let d;

		// signets
		if(this.stats.type === 21){
			let l1 = DESC_ADDITIONAL.mesmer.signet1[this.lang];
			let l2 = DESC_ADDITIONAL.mesmer.signet2[this.lang];
			let sc = Helpers.in_array(1340, this.extraAttr) && this.data.attribute !== -1;

			if(this.data.profession === 5){
				d = sc && this.id !== 63 ? l1 : l2;
			}
			else if(this.stats.activation >= 2){
				d = sc ? l1 : l2;
			}
			else{
				d = sc ? DESC_ADDITIONAL.mesmer.signet3[this.lang] : false;
			}

			d = d.replace(/{VAL}/, this.effectText(calc1));
		}
		// spells
		else if(Helpers.in_array(this.stats.type, SKILL_A_FASTCAST)){

			if(this.data.profession === 5){
				d =  DESC_ADDITIONAL.mesmer.spell1[this.lang]
					.replace(/{VAL1}/, '<span class="effect">' + calc2 + '</span>')
					.replace(/{VAL2}/, '<span class="effect">' + calc1 + '</span>')
			}
			else if(this.stats.activation >= 2){
				d =  DESC_ADDITIONAL.mesmer.spell2[this.lang].replace(/{VAL}/, this.effectText(calc2));
			}

		}

		if(!d){
			d = DESC_ADDITIONAL.mesmer.spell3[this.lang]
				.replace(/{VAL1}/, this.effectText(calc2))
				.replace(/{VAL2}/g, this.effectText(calc1));
		}

		return d;
	}

	/**
	 * Elementalist -> Energy storage
	 *
	 * @returns {string}
	 */
	elementalist(){
		return DESC_ADDITIONAL.elementalist.self[this.lang].replace(/{VAL}/, this.effectText(this.pri_val * 3));
	}

	/**
	 * Assassin -> Critical strikes
	 *
	 * @returns {string}
	 */
	assassin(){
		// todo: check for critical eye etc.
		return DESC_ADDITIONAL.assassin.self[this.lang]
			.replace(/{VAL1}/, this.effectText(this.pri_val))
			.replace(/{VAL2}/, this.effectText(Math.floor((this.pri_val + 2) / 5)));
	}

	/**
	 * Ritualist -> Spawning power
	 *
	 * @returns {string}
	 */
	ritualist(){
		let calc = this.pri_val * 4;
		let d;

		if(this.stats.type === 27){
			d =  DESC_ADDITIONAL.ritualist.weaponspell[this.lang];
		}
		else if(Helpers.in_array(this.stats.type, SKILL_A_SPAWNING) || Helpers.in_array(this.id, SKILLS_MINION) || this.id === 1239){
			d =  DESC_ADDITIONAL.ritualist.creature[this.lang];
		}
		else{
			d =  DESC_ADDITIONAL.ritualist.other[this.lang];
		}

		return d.replace(/{VAL}/g, this.effectText(calc));
	}

	/**
	 * Paragon -> Leadership
	 *
	 * @returns {string}
	 */
	paragon(){
		let d = Helpers.in_array(this.stats.type, SKILL_A_LEADERSHIP)
			? DESC_ADDITIONAL.paragon.self[this.lang]
			: DESC_ADDITIONAL.paragon.other[this.lang];

		return d.replace(/{VAL}/, this.effectText(Math.floor(this.pri_val / 2)));
	}

	/**
	 * Dervish -> Mysticism
	 *
	 * @returns {string}
	 */
	dervish(){
		let d = Helpers.in_array(this.stats.type, SKILL_A_MYSTICISM)
			? DESC_ADDITIONAL.dervish.self[this.lang]
			: DESC_ADDITIONAL.dervish.other[this.lang];

		return d.replace(/{VAL1}/, this.effectText(this.pri_val * 4)).replace(/{VAL2}/, this.effectText(this.pri_val));
	}

}



// start the action
new GWTooltip(o).init();



// @todo
document.querySelectorAll('.gwbb-icon.save, .gwbb-icon.pwnd').forEach(e => {

	e.addEventListener('click', ev => {
		let skillbar = e.parentElement.parentElement; // i hate this so much. prototype: e.up('gwbb-build')...
		let code = skillbar.dataset.code;

		if(e.className.match(/pwnd/)){
			let name = skillbar.previousSibling
				? skillbar.previousSibling.getElementsByClassName('name')[0].innerText
				: '';

			window.location = 'pwnd://vorlage/' + code + '-' + Helpers.base64_encode(name);

			return;
		}
		else if(e.className.match(/save/)){
			console.log(code);

			return;
		}

		console.log('<display equipment...>');

	});


});

})(GWTooltipOptions);
