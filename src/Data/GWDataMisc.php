<?php
/**
 * Class GWDataMisc
 *
 * @filesource   GWDataMisc.php
 * @created      30.04.2018
 * @package      chillerlan\GW1DB\Data
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DB\Data;

class GWDataMisc{

	const languages = ['de', 'en'];

	const campaigns = [
		0 => ['name' => ['de' => 'Basis',            'en' => 'Core',            ], 'continent' => ['de' => 'Die Nebel', 'en' => 'The Mists',],],
		1 => ['name' => ['de' => 'Prophecies',       'en' => 'Prophecies',      ], 'continent' => ['de' => 'Tyria',     'en' => 'Tyria',    ],],
		2 => ['name' => ['de' => 'Factions',         'en' => 'Factions',        ], 'continent' => ['de' => 'Cantha',    'en' => 'Cantha',   ],],
		3 => ['name' => ['de' => 'Nightfall',        'en' => 'Nightfall',       ], 'continent' => ['de' => 'Elona',     'en' => 'Elona',    ],],
		4 => ['name' => ['de' => 'Eye of the North', 'en' => 'Eye of the North',], 'continent' => ['de' => 'Tyria',     'en' => 'Tyria',    ],],
	];

	const professions = [
		0  => ['pri' => -1, 'name' => ['de' => 'keine',           'en' => 'none',         'fr' => 'Baguette',     ], 'abbr' => ['de' => 'X', 'en' => 'X' , 'fr' => 'X', ], 'effect' => []],
		1  => ['pri' => 17, 'name' => ['de' => 'Krieger',         'en' => 'Warrior',      'fr' => 'Guerrier',     ], 'abbr' => ['de' => 'K', 'en' => 'W' , 'fr' => 'G', ], 'effect' => [2, 3, 4, 5, 6, 7, 8, 9, 10, 12]],
		2  => ['pri' => 23, 'name' => ['de' => 'Waldläufer',      'en' => 'Ranger',       'fr' => 'Rôdeur',       ], 'abbr' => ['de' => 'W', 'en' => 'R' , 'fr' => 'R', ], 'effect' => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 17, 18, 19, 30, 31, 32]],
		3  => ['pri' => 16, 'name' => ['de' => 'Mönch',           'en' => 'Monk',         'fr' => 'Moine',        ], 'abbr' => ['de' => 'Mö','en' => 'Mo', 'fr' => 'M', ], 'effect' => []],
		4  => ['pri' =>  6, 'name' => ['de' => 'Nekromant',       'en' => 'Necromancer',  'fr' => 'Nécromant',    ], 'abbr' => ['de' => 'N', 'en' => 'N' , 'fr' => 'N', ], 'effect' => []],
		5  => ['pri' =>  0, 'name' => ['de' => 'Mesmer',          'en' => 'Mesmer',       'fr' => 'Envoûteur',    ], 'abbr' => ['de' => 'Me','en' => 'Me', 'fr' => 'En',], 'effect' => [22, 23, 24, 25, 26, 27, 28]],
		6  => ['pri' => 12, 'name' => ['de' => 'Elementarmagier', 'en' => 'Elementalist', 'fr' => 'Elémentaliste',], 'abbr' => ['de' => 'E', 'en' => 'E' , 'fr' => 'El',], 'effect' => []],
		7  => ['pri' => 35, 'name' => ['de' => 'Assassine',       'en' => 'Assassin',     'fr' => 'Assassin',     ], 'abbr' => ['de' => 'A', 'en' => 'A' , 'fr' => 'A', ], 'effect' => []],
		8  => ['pri' => 36, 'name' => ['de' => 'Ritualist',       'en' => 'Ritualist',    'fr' => 'Ritualiste',   ], 'abbr' => ['de' => 'R', 'en' => 'Rt', 'fr' => 'Rt',], 'effect' => [18, 19, 32]],
		9  => ['pri' => 40, 'name' => ['de' => 'Paragon',         'en' => 'Paragon',      'fr' => 'Parangon',     ], 'abbr' => ['de' => 'P', 'en' => 'P' , 'fr' => 'P', ], 'effect' => [13, 20]],
		10 => ['pri' => 44, 'name' => ['de' => 'Derwisch',        'en' => 'Dervish',      'fr' => 'Derviche',     ], 'abbr' => ['de' => 'D', 'en' => 'D' , 'fr' => 'D', ], 'effect' => [23, 33]],
	];

	const attributes = [
		-9 => ['prof' =>  0, 'pri' => false, 'max' => 10, 'name' => ['de' => 'Norntitel',                'en' => 'Norn Title Track',                   'fr' => '',], 'abbr' => ['de' => '', 'en' => 'nor',    'fr' => '',],],
		-8 => ['prof' =>  0, 'pri' => false, 'max' => 10, 'name' => ['de' => 'Ebon-Vorhut-Titel',        'en' => 'Ebon Vanguard Title Track',          'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ebo',    'fr' => '',],],
		-7 => ['prof' =>  0, 'pri' => false, 'max' => 10, 'name' => ['de' => 'Deldrimortitel',           'en' => 'Deldrimor Title Track',              'fr' => '',], 'abbr' => ['de' => '', 'en' => 'del',    'fr' => '',],],
		-6 => ['prof' =>  0, 'pri' => false, 'max' => 10, 'name' => ['de' => 'Asuratitel',               'en' => 'Asura Title Track',                  'fr' => '',], 'abbr' => ['de' => '', 'en' => 'asu',    'fr' => '',],],
		-5 => ['prof' =>  0, 'pri' => false, 'max' => 12, 'name' => ['de' => 'Freund der Kurzick',       'en' => 'Friend of the Kurzicks Title Track', 'fr' => '',], 'abbr' => ['de' => '', 'en' => 'kur',    'fr' => '',],],
		-4 => ['prof' =>  0, 'pri' => false, 'max' => 12, 'name' => ['de' => 'Freund der Luxon',         'en' => 'Friend of the Luxons Title Track',   'fr' => '',], 'abbr' => ['de' => '', 'en' => 'lux',    'fr' => '',],],
		-3 => ['prof' =>  0, 'pri' => false, 'max' =>  8, 'name' => ['de' => 'Lichtbringertitel',        'en' => 'Lightbringer Title Track',           'fr' => '',], 'abbr' => ['de' => '', 'en' => 'lig',    'fr' => '',],],
		-2 => ['prof' =>  0, 'pri' => false, 'max' => 10, 'name' => ['de' => 'Sonnenspeertitel',         'en' => 'Sunspear Title Track',               'fr' => '',], 'abbr' => ['de' => '', 'en' => 'sun',    'fr' => '',],],
		-1 => ['prof' =>  0, 'pri' => false, 'max' =>  0, 'name' => ['de' => 'Kein Attribut',            'en' => 'No Attribute',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'noa',    'fr' => '',],],
		 0 => ['prof' =>  5, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Schnellwirkung',           'en' => 'Fast Casting',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'fas',    'fr' => '',],],
		 1 => ['prof' =>  5, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Illusionsmagie',           'en' => 'Illusion Magic',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ill',    'fr' => '',],],
		 2 => ['prof' =>  5, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Beherrschungsmagie',       'en' => 'Domination Magic',                   'fr' => '',], 'abbr' => ['de' => '', 'en' => 'dom',    'fr' => '',],],
		 3 => ['prof' =>  5, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Inspirationsmagie',        'en' => 'Inspiration Magic',                  'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ins',    'fr' => '',],],
		 4 => ['prof' =>  4, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Blutmagie',                'en' => 'Blood Magic',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'blo',    'fr' => '',],],
		 5 => ['prof' =>  4, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Todesmagie',               'en' => 'Death Magic',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'dea',    'fr' => '',],],
		 6 => ['prof' =>  4, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Seelensammlung',           'en' => 'Soul Reaping',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'sou',    'fr' => '',],],
		 7 => ['prof' =>  4, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Flüche',                   'en' => 'Curses',                             'fr' => '',], 'abbr' => ['de' => '', 'en' => 'cur',    'fr' => '',],],
		 8 => ['prof' =>  6, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Luftmagie',                'en' => 'Air Magic',                          'fr' => '',], 'abbr' => ['de' => '', 'en' => 'air',    'fr' => '',],],
		 9 => ['prof' =>  6, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Erdmagie',                 'en' => 'Earth Magic',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ear',    'fr' => '',],],
		10 => ['prof' =>  6, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Feuermagie',               'en' => 'Fire Magic',                         'fr' => '',], 'abbr' => ['de' => '', 'en' => 'fir',    'fr' => '',],],
		11 => ['prof' =>  6, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Wassermagie',              'en' => 'Water Magic',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'wat',    'fr' => '',],],
		12 => ['prof' =>  6, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Energiespeicherung',       'en' => 'Energy Storage',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ene',    'fr' => '',],],
		13 => ['prof' =>  3, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Heilgebete',               'en' => 'Healing Prayers',                    'fr' => '',], 'abbr' => ['de' => '', 'en' => 'hea',    'fr' => '',],],
		14 => ['prof' =>  3, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Peinigungsgebete',         'en' => 'Smiting Prayers',                    'fr' => '',], 'abbr' => ['de' => '', 'en' => 'smi',    'fr' => '',],],
		15 => ['prof' =>  3, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Schutzgebete',             'en' => 'Protection Prayers',                 'fr' => '',], 'abbr' => ['de' => '', 'en' => 'pro',    'fr' => '',],],
		16 => ['prof' =>  3, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Gunst der Götter',         'en' => 'Divine Favor',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'div',    'fr' => '',],],
		17 => ['prof' =>  1, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Stärke',                   'en' => 'Strength',                           'fr' => '',], 'abbr' => ['de' => '', 'en' => 'str',    'fr' => '',],],
		18 => ['prof' =>  1, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Axtbeherrschung',          'en' => 'Axe Mastery',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'axe',    'fr' => '',],],
		19 => ['prof' =>  1, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Hammerbeherrschung',       'en' => 'Hammer Mastery',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'ham',    'fr' => '',],],
		20 => ['prof' =>  1, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Schwertkunst',             'en' => 'Swordsmanship',                      'fr' => '',], 'abbr' => ['de' => '', 'en' => 'swo',    'fr' => '',],],
		21 => ['prof' =>  1, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Taktik',                   'en' => 'Tactics',                            'fr' => '',], 'abbr' => ['de' => '', 'en' => 'tac',    'fr' => '',],],
		22 => ['prof' =>  2, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Tierbeherrschung',         'en' => 'Beast Mastery',                      'fr' => '',], 'abbr' => ['de' => '', 'en' => 'bea',    'fr' => '',],],
		23 => ['prof' =>  2, 'pri' => true,  'max' => 20, 'name' => ['de' => 'Fachkenntnis',             'en' => 'Expertise',                          'fr' => '',], 'abbr' => ['de' => '', 'en' => 'exp',    'fr' => '',],],
		24 => ['prof' =>  2, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Überleben in der Wildnis', 'en' => 'Wilderness Survival',                'fr' => '',], 'abbr' => ['de' => '', 'en' => 'wil',    'fr' => '',],],
		25 => ['prof' =>  2, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Treffsicherheit',          'en' => 'Marksmanship',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'mar',    'fr' => '',],],
		29 => ['prof' =>  7, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Dolchbeherrschung',        'en' => 'Dagger Mastery',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'dag',    'fr' => '',],],
		30 => ['prof' =>  7, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Tödliche Künste',          'en' => 'Deadly Arts',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'dead',   'fr' => '',],],
		31 => ['prof' =>  7, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Schattenkünste',           'en' => 'Shadow Arts',                        'fr' => '',], 'abbr' => ['de' => '', 'en' => 'sha',    'fr' => '',],],
		32 => ['prof' =>  8, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Zwiesprache',              'en' => 'Communing',                          'fr' => '',], 'abbr' => ['de' => '', 'en' => 'com',    'fr' => '',],],
		33 => ['prof' =>  8, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Wiederherstellungsmagie',  'en' => 'Restoration Magic',                  'fr' => '',], 'abbr' => ['de' => '', 'en' => 'res',    'fr' => '',],],
		34 => ['prof' =>  8, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Kanalisierungsmagie',      'en' => 'Channeling Magic',                   'fr' => '',], 'abbr' => ['de' => '', 'en' => 'cha',    'fr' => '',],],
		35 => ['prof' =>  7, 'pri' => true,  'max' => 20, 'name' => ['de' => 'Kritische Stöße',          'en' => 'Critical Strikes',                   'fr' => '',], 'abbr' => ['de' => '', 'en' => 'cri',    'fr' => '',],],
		36 => ['prof' =>  8, 'pri' => true,  'max' => 21, 'name' => ['de' => 'Macht des Herbeirufens',   'en' => 'Spawning Power',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'spa',    'fr' => '',],],
		37 => ['prof' =>  9, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Speerbeherrschung',        'en' => 'Spear Mastery',                      'fr' => '',], 'abbr' => ['de' => '', 'en' => 'spe',    'fr' => '',],],
		38 => ['prof' =>  9, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Befehlsgewalt',            'en' => 'Command',                            'fr' => '',], 'abbr' => ['de' => '', 'en' => 'comma',  'fr' => '',],],
		39 => ['prof' =>  9, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Motivation',               'en' => 'Motivation',                         'fr' => '',], 'abbr' => ['de' => '', 'en' => 'mot',    'fr' => '',],],
		40 => ['prof' =>  9, 'pri' => true,  'max' => 20, 'name' => ['de' => 'Führung',                  'en' => 'Leadership',                         'fr' => '',], 'abbr' => ['de' => '', 'en' => 'lea',    'fr' => '',],],
		41 => ['prof' => 10, 'pri' => false, 'max' => 21, 'name' => ['de' => 'Sensenbeherrschung',       'en' => 'Scythe Mastery',                     'fr' => '',], 'abbr' => ['de' => '', 'en' => 'scy',    'fr' => '',],],
		42 => ['prof' => 10, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Windgebete',               'en' => 'Wind Prayers',                       'fr' => '',], 'abbr' => ['de' => '', 'en' => 'win',    'fr' => '',],],
		43 => ['prof' => 10, 'pri' => false, 'max' => 20, 'name' => ['de' => 'Erdgebete',                'en' => 'Earth Prayers',                      'fr' => '',], 'abbr' => ['de' => '', 'en' => 'earthp', 'fr' => '',],],
		44 => ['prof' => 10, 'pri' => true,  'max' => 20, 'name' => ['de' => 'Mystik',                   'en' => 'Mysticism',                          'fr' => '',], 'abbr' => ['de' => '', 'en' => 'mys',    'fr' => '',],],
	];

	/**
	 * map of skilltypes affected by primary attributes
	 */
	const SKILL_A_EXPERTISE  = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 18, 19, 31, 32];
	const SKILL_A_FASTCAST   = [22, 23, 24, 25, 26, 27, 28];
	const SKILL_A_FASTCAST_R = [22, 23, 24];
	const SKILL_A_SPAWNING   = [18, 19, 32];
	const SKILL_A_LEADERSHIP = [13, 20];
	const SKILL_A_MYSTICISM  = [23, 33];
	const SKILL_A_STRENGTH   = [2, 3, 4, 5, 6, 7, 8, 9, 10, 12];

	/**
	 * map of the "special" skills
	 */

	// skills that add extra attribute points
	const SKILLS_ATTRIBUTE_EXTRA = [111, 114, 164, 198, 199, 206, 946, 1217, 1340, 1346, 1378, 1724, 1951, 2094, 2139];

	// minion skills
	const SKILLS_MINION = [83, 84, 85, 114, 122, 805, 832, 1351, 1355];

	// spawning power skill fixtures
	const SKILL_FIX_SPAWNING = [787, 792, 793, 795, 964, 983, 1257, 1258, 1267, 1749, 1750, 1752, 2148, 2149, 2219];

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

	// touch skills
	const SKILLS_TOUCH = [
		29, 58, 154, 155, 156, 157, 158, 231, 232, 312, 313, 314, 424, 525, 786, 801, 918, 990, 1009, 1045, 1059,
		1077, 1078, 1079, 1095, 1131, 1146, 1155, 1263, 1328, 1401, 1406, 1439, 1447, 1528, 1534, 1545, 1619, 1645,
		1818, 1862, 1894, 2011, 2080, 2081, 2088, 2114, 2129, 2213, 2214, 2215, 2244, 2357, 2375, 2376, 2380, 2385,
		2492, 2501, 2506
	];

	// template: 0. Weapon, 1. Off-hand, 2. Chest, 3. Legs, 4. Head, 5. Feet, 6. Hands
	const ITEM_TYPES = [
		// armor
		 2 => ['de' => 'Brust',      'en' => 'Chest Armor',],
		 3 => ['de' => 'Beine',      'en' => 'Legs Armor', ],
		 4 => ['de' => 'Kopf',       'en' => 'Headgear',   ],
		 5 => ['de' => 'Füße',       'en' => 'Footwear',   ],
		 6 => ['de' => 'Hände',      'en' => 'Hands Armor',],
		// main hand
		10 => ['de' => 'Axt',        'en' => 'Axe',        ],
		11 => ['de' => 'Bogen',      'en' => 'Bow',        ],
		12 => ['de' => 'Dolche',     'en' => 'Daggers',    ],
		13 => ['de' => 'Hammer',     'en' => 'Hammer',     ],
		14 => ['de' => 'Schwert',    'en' => 'Sword',      ],
		15 => ['de' => 'Sense',      'en' => 'Scythe',     ],
		16 => ['de' => 'Speer',      'en' => 'Spear',      ],
		17 => ['de' => 'Stab',       'en' => 'Staff',      ],
		18 => ['de' => 'Zauberstab', 'en' => 'Wand',       ],
		// off-hand
		21 => ['de' => 'Fokus',      'en' => 'Focus Item', ],
		22 => ['de' => 'Schild',     'en' => 'Shield',     ],
	];

	const ITEM_EFFECT = [
		 0 => ['de' => 'Rüstung',        'en' => 'Armor',        ],
		 1 => ['de' => 'Energie',        'en' => 'Energy',       ],
		// damage types
		10 => ['de' => 'Blitz-Schaden',  'en' => 'Lightning Dmg',],
		11 => ['de' => 'Chaos-Schaden',  'en' => 'Chaos Dmg',    ],
		12 => ['de' => 'Dunkel-Schaden', 'en' => 'Dark Dmg',     ],
		13 => ['de' => 'Erd-Schaden',    'en' => 'Earth Dmg',    ],
		14 => ['de' => 'Feuer-Schaden',  'en' => 'Fire Dmg',     ],
		15 => ['de' => 'Hieb-Schaden',   'en' => 'Slashing Dmg', ],
		16 => ['de' => 'Kälte-Schaden',  'en' => 'Cold Dmg',     ],
		17 => ['de' => 'Sakral-Schaden', 'en' => 'Holy Dmg',     ],
		18 => ['de' => 'Stich-Schaden',  'en' => 'Piercing Dmg', ],
		19 => ['de' => 'Stumpf-Schaden', 'en' => 'Blunt Dmg',    ],
	];

	const ITEM_MOD_TYPES = [
		0 => 'insignia',
		1 => 'minor',
		2 => 'major',
		3 => 'superior',
		4 => 'prefix',
		5 => 'suffix',
		6 => 'inscription'
	];

	const MOD_BASE = [
		 0 => ['de' => 'Axt',                            'en' => 'Axe',                   ],
		 1 => ['de' => 'Bogen',                          'en' => 'Bow',                   ],
		 2 => ['de' => 'Dolche',                         'en' => 'Daggers',               ],
		 3 => ['de' => 'Hammer',                         'en' => 'Hammer',                ],
		 4 => ['de' => 'Schwert',                        'en' => 'Sword',                 ],
		 5 => ['de' => 'Sense',                          'en' => 'Scythe',                ],
		 6 => ['de' => 'Speer',                          'en' => 'Spear',                 ],
		 7 => ['de' => 'Stab',                           'en' => 'Staff',                 ],
		 8 => ['de' => 'Zauberstab',                     'en' => 'Wand',                  ],
		 9 => ['de' => 'Schild',                         'en' => 'Shield',                ],
		10 => ['de' => 'Waffen',                         'en' => 'Weapons',               ],
		11 => ['de' => 'Kampfwaffen',                    'en' => 'Martial Weapons',       ],
		12 => ['de' => 'Zauberwirker-Waffen',            'en' => 'Caster Weapons',        ],
		13 => ['de' => 'Fokus-Gegenstände',              'en' => 'Focus Items',           ],
		14 => ['de' => 'Fokus-Gegenstände oder Schilde', 'en' => 'Focus Items or Shields',],
		15 => ['de' => 'Rüstung',                        'en' => 'Armor',                 ],
		16 => ['de' => 'Assassinen-Rüstung',             'en' => 'Assassin Armor',        ],
		17 => ['de' => 'Derwisch-Rüstung',               'en' => 'Dervish Armor',         ],
		18 => ['de' => 'Elementarmagier-Rüstung',        'en' => 'Elementalist Armor',    ],
		19 => ['de' => 'Krieger-Rüstung',                'en' => 'Warrior Armor',         ],
		20 => ['de' => 'Mesmer-Rüstung',                 'en' => 'Mesmer Armor',          ],
		21 => ['de' => 'Mönchs-Rüstung',                 'en' => 'Monk Armor',            ],
		22 => ['de' => 'Nekromanten-Rüstung',            'en' => 'Necromancer Armor',     ],
		23 => ['de' => 'Paragon-Rüstung',                'en' => 'Paragon Armor',         ],
		24 => ['de' => 'Ritualisten-Rüstung',            'en' => 'Ritualist Armor',       ],
		25 => ['de' => 'Waldläufer-Rüstung',             'en' => 'Ranger Armor',          ],
	];

	const DESC_ADDITIONAL = [
		'warrior'      => [
			'self'  => [
				'de' => 'Diese Angriffsfertigkeit hat +%s%% Rüstungsdurchdringung.',
				'en' => 'This attack skill has +%s%% armor penetration.',
			],
			'other' => [
				'de' => 'Angriffsfertigkeiten haben +%s%% Rüstungsdurchdringung.',
				'en' => 'Attack skills have +%s%% armor penetration.',
			],
		],
		'ranger'       => [
			'self'  => [
				'de' => 'Diese Fertigkeit kostet %s%% weniger Energie.',
				'en' => 'This skill costs %s%% less energy.',
			],
			'other' => [
				'de' => 'Waldläufer-, Angriffs- und Berührungsfertigkeiten, sowie Rituale kosten %s%% weniger Energie.',
				'en' => 'Ranger skills, attack skills, touch skills and rituals cost %s%% less energy.',
			],
		],
		'monk'         => [
			'target' => [
				'de' => 'Das Ziel erhält %s Lebenspunkte.',
				'en' => 'Target ally gains %s health.',
			],
			'add'    => [
				'de' => 'Das Ziel erhält zusätzlich %s Lebenspunkte.',
				'en' => 'Target ally gains an additional %s health.',
			],
			'self'   => [
				'de' => 'Ihr erhaltet %s Lebenspunkte.',
				'en' => 'You gain %s health.',
			],
			'other'  => [
				'de' => 'Mönch-Zauber geben %s Lebenspunkte.',
				'en' => 'Monk spells give %s health.',
			],
		],
		'necromancer'  => [
			'self' => [
				'de' => 'Jedesmal, wenn eine Kreatur stirbt, die kein Geist ist, erhaltet Ihr %s Energie (max. 3x in 15s).',
				'en' => 'Whenever a non-spirit creature dies, You gain %s energy (max. 3x in 15s).',
			],
		],
		'mesmer'       => [
			'spell1'  => [
				'de' => 'Dieser Zauber hat noch %1$s%% seiner Aktivierungszeit und %2$s%% seiner Aufladezeit im PvE.',
				'en' => 'This spell has %1$s%% of its base activation time and %2$s%% recharge in PvE.',
			],
			'spell2'  => [
				'de' => 'Dieser Zauber hat noch %s%% seiner Aktivierungszeit.',
				'en' => 'This spell has %s%% of its base activation time.',
			],
			'spell3'  => [
				'de' => 'Zauber haben noch %1$s%%, Siegel %2$s%% ihrer Aktivierungszeit (Nicht-Mesmer-Fertigkeiten ab 2 Sekunden Aktivierung). Mesmer-Zauber haben im PvE noch %2$s%% ihrer Aufladezeit.',
				'en' => 'Spells have %1$s%%, signets %2$s%% of their activation time (non Mesmer skills with activation of 2 seconds or greater). Mesmer spells have %2$s%% of their recharge time in PvE.',

			],
			'signet1' => [
				'de' => 'Dieses Siegel hat noch %s%% seiner Aktivierungszeit und benutzt das Schnellwirkungs-Attribut wenn Symbolische Schnelligkeit aktiv ist.',
				'en' => 'This signet has %s%% of its base activation time and uses the Fast Casting attribute if Symbolic Celerity is active.',
			],
			'signet2' => [
				'de' => 'Dieses Siegel hat noch %s%% seiner Aktivierungszeit.',
				'en' => 'This signet has %s%% of its base activation time.',
			],
			'signet3' => [
				'de' => 'Dieses Siegel benutzt das Schnellwirkungs-Attribut wenn Symbolische Schnelligkeit aktiv ist.',
				'en' => 'This signet uses the Fast Casting attribute if Symbolic Celerity is active.',
			],
		],
		'elementalist' => [
			'self' => [
				'de' => 'Eure maximalen Energiepunkte erhöhen sich um +%s.',
				'en' => 'You gain +%s maximum energy.',
			],
		],
		'ritualist'    => [
			'weaponspell' => [
				'de' => 'Dieser Waffenzauber hält %s%% länger an.',
				'en' => 'This weapon spell lasts %s%% longer.',
			],
			'creature'    => [
				'de' => 'Diese Kreatur hat +%s%% maximale Lebenspunkte.',
				'en' => 'This creature has +%s%% maximum health.',
			],
			'other'       => [
				'de' => 'Belebte Kreaturen haben +%s%% maximale Lebenspunkte und Waffenzauber halten %s%% länger an.',
				'en' => 'Animated creatures have +%s%% maximum health and weapons spells last %s%% longer.',
			],
		],
		'assassin'     => [
			'self' => [
				'de' => 'Die Chance auf kritische Treffer ist um %1$s%% erhöht. Ihr erhaltet %2$s Energie für jeden kritischen Treffer.',
				'en' => 'Critical hit chance is increased by %1$s%%. You gain %2$s energy for each critical hit.',
			],
		],
		'paragon'      => [
			'self'  => [
				'de' => 'Ihr erhaltet 2 Energiepunkte für jeden von dieser Fertigkeit betroffenen Verbündeten (max. %s).',
				'en' => 'You gain 2 energy for each ally affected by this skill (max. %s).',
			],
			'other' => [
				'de' => 'Ihr erhaltet 2 Energiepunkte für jeden von Euren Anfeuerungsrufen und Schreien betroffenen Verbündeten (max. %s).',
				'en' => 'You gain 2 energy for each ally affected by your chants and shouts (max. %s).',
			],
		],
		'dervish'      => [
			'self'  => [
				'de' => 'Diese Fertigkeit kostet %1$s%% weniger Energie und Ihr habt +%2$s Rüstung, während Ihr verzaubert seid.',
				'en' => 'This skill costs %1$s%% less energy and you gain +%2$s armor while enchanted.',
			],
			'other' => [
				'de' => 'Derwisch-Verzauberungen kosten %1$s%% weniger Energie und Ihr habt +%2$s Rüstung, während Ihr verzaubert seid.',
				'en' => 'Dervish Enchantments cost %1$s%% less energy and you gain +%2$s armor while enchanted.',
			],
		],
		'creature'     => [
			'spawning' => [
				'de' => 'Diese Kreatur hat %3$s (%1$s) Lebenspunkte und %2$s Rüstung.',
				'en' => 'This creature has %3$s (%1$s) health and %2$s armor.',
			],
			'other'    => [
				'de' => 'Diese Kreatur hat %1$s Lebenspunkte und %2$s Rüstung.',
				'en' => 'This creature has %1$s health and %2$s armor.',
			],
		],
	];

}
