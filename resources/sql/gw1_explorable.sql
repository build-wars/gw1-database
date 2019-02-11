CREATE TABLE `gw1_explorable` (
	`explorable_id` smallint(4) UNSIGNED         NOT NULL,
	`region_id`     smallint(4) UNSIGNED         NOT NULL,
	`name_en`       tinytext COLLATE utf8mb4_bin NOT NULL,
	`name_de`       tinytext COLLATE utf8mb4_bin NOT NULL,
	PRIMARY KEY (`explorable_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_explorable` (`explorable_id`, `region_id`, `name_en`, `name_de`) VALUES
	(7, 22, 'Warrior\'s Isle', 'Insel des Kriegers'),
	(8, 22, 'Hunter\'s Isle', 'Insel des Jägers'),
	(9, 22, 'Wizard\'s Isle', 'Insel des Zauberers'),
	(13, 2, 'Diessa Lowlands', 'Tiefland von Diessa'),
	(17, 4, 'Talmark Wilderness', 'Talmark-Wildnis'),
	(18, 4, 'The Black Curtain', 'Der Schwarze Vorhang'),
	(26, 7, 'Talus Chute', 'Talusschnelle'),
	(27, 3, 'Griffon\'s Mouth', 'Greifenmaul'),
	(31, 10, 'Xaquang Skyway', 'Xaquang-Himmelsweg'),
	(33, 2, 'Old Ascalon', 'Alt-Ascalon'),
	(34, 23, 'The Fissure of Woe', 'Riss des Kummers'),
	(41, 5, 'Sage Lands', 'Land der Weisen'),
	(42, 5, 'Mamnoon Lagoon', 'Mamnoon-Lagune'),
	(43, 5, 'Silverwood', 'Silberholz'),
	(44, 5, 'Ettin\'s Back', 'Ettinbuckel'),
	(45, 5, 'Reed Bog', 'Schilfmoor'),
	(46, 5, 'The Falls', 'Die Wasserfälle'),
	(47, 5, 'Dry Top', 'Trockenkuppe'),
	(48, 5, 'Tangle Root', 'Wildwurzel'),
	(53, 4, 'Tears of the Fallen', 'Tränen der Gefallenen'),
	(54, 4, 'Scoundrel\'s Rise', 'Schurkenhügel'),
	(56, 4, 'Cursed Lands', 'Verfluchtes Land'),
	(58, 4, 'North Kryta Province', 'Provinz Nordkryta'),
	(59, 4, 'Nebo Terrace', 'Nebo-Terrasse'),
	(60, 4, 'Majesty\'s Rest', 'Königsruh'),
	(61, 4, 'Twin Serpent Lakes', 'Zwillingsschlangenseen'),
	(62, 4, 'Watchtower Coast', 'Wachturmküste'),
	(63, 4, 'Stingray Strand', 'Stachelrochenstrand'),
	(64, 4, 'Kessex Peak', 'Kessex-Gipfel'),
	(67, 22, 'Burning Isle', 'Brennende Insel'),
	(68, 22, 'Frozen Isle', 'Vereiste Insel'),
	(69, 22, 'Nomad\'s Isle', 'Nomadeninsel'),
	(70, 22, 'Druid\'s Isle', 'Druideninsel'),
	(71, 22, 'Isle of the Dead', 'Insel der Toten'),
	(72, 23, 'The Underworld', 'Die Unterwelt'),
	(87, 7, 'Icedome', 'Eisdom'),
	(88, 3, 'Iron Horse Mine', 'Eisenrossmine'),
	(89, 3, 'Anvil Rock', 'Ambossstein'),
	(90, 7, 'Lornar\'s Pass', 'Lornarpass'),
	(91, 7, 'Snake Dance', 'Schlangentanz'),
	(92, 7, 'Tasca\'s Demise', 'Tascas Ableben'),
	(93, 7, 'Spearhead Peak', 'Speerspitzengipfel'),
	(94, 7, 'Ice Floe', 'Eisscholle'),
	(95, 7, 'Witman\'s Folly', 'Witmans Torheit'),
	(96, 7, 'Mineral Springs', 'Mineralquellen'),
	(97, 7, 'Dreadnought\'s Drift', 'Schreckensdrift'),
	(98, 7, 'Frozen Forest', 'Frostwald'),
	(99, 3, 'Traveler\'s Vale', 'Tal des Reisenden'),
	(100, 3, 'Deldrimor Bowl', 'Deldrimor-Becken'),
	(101, 2, 'Regent Valley', 'Regentental'),
	(102, 2, 'The Breach', 'Die Bresche'),
	(103, 2, 'Ascalon Foothills', 'Ascalon-Vorgebirge'),
	(104, 2, 'Pockmark Flats', 'Pockennarbenebene'),
	(105, 2, 'Dragon\'s Gullet', 'Drachenschlund'),
	(106, 2, 'Flame Temple Corridor', 'Flammentempel-Gang'),
	(107, 2, 'Eastern Frontier', 'Ostgrenze'),
	(108, 6, 'The Scar', 'Die Narbe'),
	(110, 6, 'Diviner\'s Ascent', 'Wahrsagerhöhe'),
	(111, 6, 'Vulture Drifts', 'Geierdünen'),
	(112, 6, 'The Arid Sea', 'Das Trockene Meer'),
	(113, 6, 'Prophet\'s Path', 'Pfad des Propheten'),
	(114, 6, 'Salt Flats', 'Salzebenen'),
	(115, 6, 'Skyward Reach', 'Himmelsspitze'),
	(121, 8, 'Perdition Rock', 'Fels der Verdammnis'),
	(127, 23, 'Scarred Earth', 'Vernarbte Erde'),
	(128, 12, 'The Eternal Grove', 'Der Ewige Hain'),
	(144, 11, 'Gyala Hatchery', 'Gyala-Brutstätte'),
	(145, 1, 'The Catacombs', 'Die Katakomben'),
	(146, 4, 'Lakeside County', 'Flussuferprovinz'),
	(147, 1, 'The Northlands', 'Nordländer'),
	(149, 1, 'Ascalon Academy', 'Ascalon-Akademie'),
	(151, 1, 'Ascalon Academy', 'Ascalon-Akademie'),
	(160, 1, 'Green Hills County', 'Grünhügel-Grafschaft'),
	(161, 1, 'Wizard\'s Folly', 'Torheit des Zauberers'),
	(162, 1, 'Regent Valley (pre-Searing)', 'Regentental (Tutorial)'),
	(190, 7, 'Sorrow\'s Furnace', 'Hochofen der Betrübnis'),
	(191, 7, 'Grenth\'s Footprint', 'Grenths Fußabdruck'),
	(195, 12, 'Drazach Thicket', 'Drazachdickicht'),
	(196, 9, 'Jaya Bluffs', 'Jaya-Klippen'),
	(197, 10, 'Shenzun Tunnels', 'Shenzun-Tunnel'),
	(198, 11, 'Archipelagos', 'Archipel'),
	(199, 11, 'Maishang Hills', 'Maishang-Hügel'),
	(200, 11, 'Mount Qinkai', 'Qinkai'),
	(201, 12, 'Melandru\'s Hope', 'Melandrus Hoffnung'),
	(202, 11, 'Rhea\'s Crater', 'Rheas Krater'),
	(203, 11, 'Silent Surf', 'Stumme Brandung'),
	(205, 12, 'Morostav Trail', 'Morostovweg'),
	(209, 12, 'Mourning Veil Falls', 'Trauerflorfälle'),
	(210, 12, 'Ferndale', 'Farntal'),
	(211, 9, 'Pongmei Valley', 'Pongmei-Tal'),
	(212, 9, 'Monastery Overlook', 'Kloster-Aussichtspunkt'),
	(227, 11, 'Unwaking Waters', 'Verschlafene Gewässer'),
	(232, 10, 'Shadow\'s Passage', 'Schattenpassage'),
	(233, 10, 'Raisu Palace', 'Raisu-Palast'),
	(235, 9, 'Panjiang Peninsula', 'Panjiang-Halbinsel'),
	(236, 9, 'Kinya Province', 'Provinz Kinya'),
	(237, 9, 'Haiju Lagoon', 'Haiju-Lagune'),
	(238, 9, 'Sunqua Vale', 'Sunqua-Tal'),
	(239, 10, 'Wajjun Bazaar', 'Wajjun-Basar'),
	(240, 10, 'Bukdek Byway', 'Bukdek-Seitenweg'),
	(241, 10, 'The Undercity', 'Die Unterstadt'),
	(244, 12, 'Arborstone', 'Arborstein'),
	(245, 9, 'Minister Cho\'s Estate', 'Minister Chos Anwesen'),
	(246, 9, 'Zen Daijun', 'Zen Daijun'),
	(247, 11, 'Boreas Seabed', 'Boreas-Meeresgrund'),
	(252, 9, 'Linnok Courtyard', 'Linnok-Hof'),
	(256, 10, 'Sunjiang District', 'Sunjiang-Bezirk'),
	(265, 10, 'Nahpui Quarter', 'Nahpuiviertel'),
	(269, 10, 'Tahnnakai Temple', 'Tahnnakai-Tempel'),
	(280, 22, 'Isle of the Nameless', 'Insel der Namenlosen'),
	(285, 9, 'Monastery Overlook', 'Kloster-Aussichtspunkt'),
	(290, 10, 'Bejunkan Pier', 'Bejunkan-Pier'),
	(301, 10, 'Raisu Pavilion', 'Raisu-Pavillion'),
	(302, 10, 'Kaineng Docks', 'Docks von Kaineng'),
	(313, 9, 'Saoshang Trail', 'Saoshangweg'),
	(344, 23, 'The Hall of Heroes', 'Die Halle der Helden'),
	(345, 23, 'The Courtyard', 'Der Hof'),
	(346, 23, 'Scarred Earth', 'Vernarbte Erde'),
	(347, 23, 'The Underworld (Tomb of the Primeval Kings)', 'Die Unterwelt (Grab der altehrwürdigen Könige)'),
	(351, 10, 'Divine Path', 'Göttlicher Pfad'),
	(361, 22, 'Isle of Weeping Stone', 'Insel des trauernden Steins'),
	(362, 22, 'Isle of Jade', 'Jadeinsel'),
	(363, 22, 'Imperial Isle', 'Kaiserinsel'),
	(364, 22, 'Isle of Meditation', 'Insel der Meditation'),
	(369, 14, 'Jahai Bluffs', 'Jahai-Klippen'),
	(371, 14, 'Marga Coast', 'Marga-Küste'),
	(373, 14, 'Sunward Marches', 'Sonnenwärtige Sümpfe'),
	(375, 14, 'Barbarous Shore', 'Barbarenküste'),
	(377, 14, 'Bahdok Caverns', 'Bahdok-Höhlen'),
	(379, 14, 'Dejarin Estate', 'Dejarin-Anwesen'),
	(380, 14, 'Arkjok Ward', 'Arkjok-Bastei'),
	(382, 14, 'Gandara, the Moon Fortress', 'Gandara, die Mondfestung'),
	(384, 14, 'The Floodplain of Mahnkelon', 'Die Schwemmebene von Mahnkelon'),
	(385, 4, 'Lion\'s Arch', 'Löwenstein'),
	(386, 14, 'Turai\'s Procession', 'Turais Weg'),
	(392, 15, 'Yatendi Canyons', 'Yahtendi-Schluchten'),
	(394, 15, 'Garden of Seborhin', 'Seborhin-Garten'),
	(395, 15, 'Holdings of Chokhin', 'Güter von Chokhin'),
	(397, 15, 'Vehjin Mines', 'Vehjin-Minen'),
	(399, 15, 'Forum Highlands', 'Forum-Hochland'),
	(400, 10, 'Kaineng Center', 'Zentrum von Kaineng'),
	(402, 15, 'Resplendent Makuun', 'Makuun die Leuchtende'),
	(404, 15, 'Wilderness of Bahdza', 'Wildnis von Bahdza'),
	(406, 15, 'Vehtendi Valley', 'Vehtendi-Tal'),
	(413, 15, 'The Hidden City of Ahdashim', 'Verborgene Stadt von Ahdashim'),
	(415, 4, 'Lion\'s Gate', 'Löwentor'),
	(419, 15, 'The Mirror of Lyss', 'Der Spiegel von Lyss'),
	(420, 14, 'Secure the Refuge', 'Sichert den Zufluchtsort'),
	(422, 13, 'Kamadan, Jewel of Istan', 'Kamadan, Juwel von Istan'),
	(423, 13, 'The Tribunal', 'Das Tribunal'),
	(429, 13, 'Consulate', 'Konsulat'),
	(430, 13, 'Plains of Jarin', 'Flachland von Jarin'),
	(432, 13, 'Cliffs of Dohjok', 'Felsen von Dohjok'),
	(436, 14, 'Command Post', 'Kommandostelle'),
	(437, 16, 'Joko\'s Domain', 'Jokos Domäne'),
	(439, 16, 'The Ruptured Heart', 'Das Zerrissene Herz'),
	(441, 16, 'The Shattered Ravines', 'Die Zerklüfteten Schluchten'),
	(443, 16, 'Poisoned Outcrops', 'Giftige Auswüchse'),
	(444, 16, 'The Sulfurous Wastes', 'Die Schwefel-Einöde'),
	(446, 16, 'The Alkali Pan', 'Das Alkalibecken'),
	(447, 13, 'Cliffs of Dohjok', 'Felsen von Dohjok'),
	(448, 16, 'Crystal Overlook', 'Kristallspitze'),
	(455, 15, 'Nightfallen Garden', 'Garten in Finsternis'),
	(456, 13, 'Churrhir Fields', 'Churrhir-Felder'),
	(461, 23, 'The Underworld', 'Die Unterwelt'),
	(462, 17, 'Heart of Abaddon', 'Abaddons Herz'),
	(463, 23, 'The Underworld', 'Die Unterwelt'),
	(465, 17, 'Nightfallen Jahai', 'Jahai in Finsternis'),
	(466, 17, 'Depths of Madness', 'Abgründe des Wahnsinns'),
	(468, 17, 'Domain of Fear', 'Domäne der Angst'),
	(470, 17, 'Domain of Pain', 'Domäne der Schmerzen'),
	(471, 5, 'Bloodstone Fen', 'Blutsteinsumpf'),
	(472, 17, 'Domain of Secrets', 'Domäne der Geheimnisse'),
	(474, 17, 'Domain of Anguish', 'Domäne der Pein'),
	(481, 13, 'Fahranur, The First City', 'Fahranur, die Erste Stadt'),
	(482, 18, 'Bjora Marches', 'Bjora-Sümpfe'),
	(483, 13, 'Zehlon Reach', 'Zehlon-Bucht'),
	(484, 13, 'Lahtenda Bog', 'Lahtenda-Sumpf'),
	(485, 20, 'Arbor Bay', 'Arborbucht'),
	(486, 13, 'Issnur Isles', 'Issnur-Inseln'),
	(488, 13, 'Mehtani Keys', 'Mehtani-Archipel'),
	(490, 13, 'Island of Shehkah', 'Insel Shehkah'),
	(499, 18, 'Ice Cliff Chasms', 'Eisklippen-Abgründe'),
	(500, 15, 'Bokka Amphitheatre', 'Amphitheater von Bokka'),
	(501, 20, 'Riven Earth', 'Zerrissene Erde'),
	(503, 17, 'Throne of Secrets', 'Thron der Geheimnisse'),
	(505, 9, 'Shing Jea Monastery (mission)', 'Kloster von Shing Jea (Mission)'),
	(506, 9, 'Haiju Lagoon (mission)', 'Haiju-Lagune (Mission)'),
	(507, 9, 'Jaya Bluffs (mission)', 'Jaya-Klippen (Mission)'),
	(508, 9, 'Seitung Harbor (mission)', 'Hafen von Seitung (Mission)'),
	(509, 9, 'Tsumei Village (mission)', 'Dorf Tsumei (Mission)'),
	(510, 9, 'Seitung Harbor (mission 2)', 'Hafen von Seitung (Mission 2)'),
	(511, 9, 'Tsumei Village (mission 2)', 'Dorf Tsumei (Mission 2)'),
	(513, 18, 'Drakkar Lake', 'Drakkar-See'),
	(531, 22, 'Uncharted Isle', 'Unbekannte Insel'),
	(532, 22, 'Isle of Wurms', 'Insel der Würmer'),
	(539, 22, 'Corrupted Isle', 'Verdorbene Insel'),
	(540, 22, 'Isle of Solitude', 'Insel der Einsamkeit'),
	(543, 13, 'Sun Docks', 'Sonnenhafen'),
	(546, 18, 'Jaga Moraine', 'Jaga-Moräne'),
	(548, 18, 'Norrhart Domains', 'Norrhart-Gebiete'),
	(553, 18, 'Varajar Fells', 'Varajar-Moor'),
	(558, 20, 'Sparkfly Swamp', 'Funkenschwärmersumpf'),
	(561, 17, 'The Troubled Keeper', 'Hüterin in Not'),
	(566, 20, 'Verdant Cascades', 'Grüne Kaskaden'),
	(569, 20, 'Magus Stones', 'Magussteine'),
	(572, 20, 'Alcazia Tangle', 'Alcazia-Dickicht'),
	(625, 21, 'Battledepths', 'Schlachttiefen'),
	(646, 18, 'Hall of Monuments', 'Halle der Monumente'),
	(647, 19, 'Dalada Uplands', 'Dalada-Hochland'),
	(649, 19, 'Grothmar Wardowns', 'Grothmar-Kriegshügel'),
	(651, 19, 'Sacnoth Valley', 'Sacnoth-Tal'),
	(653, 18, 'Curse of the Nornbear', 'Der Fluch des Nornbären'),
	(654, 18, 'Blood Washes Blood', 'Blut wäscht Blut'),
	(664, 20,  'Genius Operated Living Enchanted Manifestation', 'Geführter Operand Lebender Entfesselter Magie'),
	(665, 19, 'Against the Charr', 'Gegen die Charr'),
	(669, 19, 'Assault on the Stronghold', 'Der Angriff auf die Festung'),
	(673, 21, 'A Time for Heroes', 'Eine Zeit für Helden'),
	(674, 19, 'Warband Training', 'Trupp-Übungen'),
	(678, 18, 'Attack of the Nornbear', 'Dem Nornbären auf der Spur'),
	(686, 20, 'Polymock Coliseum', 'Polymock-Kolosseum'),
	(687, 18, 'Polymock Glacier', 'Polymock-Gletscher'),
	(688, 19, 'Polymock Crossing', 'Polymock-Kreuzung'),
	(690, 18, 'Cold as Ice', 'Eiskalt erwischt'),
	(691, 4, 'Beneath Lion\'s Arch', 'Unter Löwenstein'),
	(692, 10, 'Tunnels Below Cantha', 'Tunnel unter Cantha'),
	(693, 13, 'Caverns Below Kamadan', 'Höhlen unter Kamadan'),
	(695, 18, 'Service: In Defense of the Eye', 'Dienst: Die Verteidigung des Auges'),
	(696, 18, 'Mano a Norn-o', 'Mensch gegen Norn'),
	(697, 18, 'Service: Practice, Dummy', 'Dienst: Kampfübung'),
	(698, 18, 'Hero Tutorial', 'Helden-Tutorial'),
	(700, 18, 'The Norn Fighting Tournament', 'Die Kampf-Meisterschaft der Norn'),
	(702, 18, 'Norn Brawling Championship', 'Die Rauferei-Meisterschaft der Norn'),
	(703, 18, 'Kilroy\'s Punchout Training', 'Kilroys Training der Fliegenden Fäuste'),
	(705, 20, 'The Justiciar\'s End', 'Das Ende des Justiziars'),
	(707, 18, 'The Great Norn Alemoot', 'Der Große Bierrat der Norn'),
	(708, 18, 'Varajar Fells', 'Varajar-Moor'),
	(710, 21, 'Epilogue', 'Epilog'),
	(711, 20, 'Insidious Remnants', 'Heimtückische Überreste'),
	(717, 21, 'Attack on Jalis\'s Camp', 'Angriff auf Jalis\' Lager'),
	(726, 18, 'Kilroy\'s Punchout Tournament', 'Kilroys Turnier der Fliegenden Fäuste'),
	(727, 2, 'Special Ops: Flame Temple Corridor', 'Spezialeinsatz: Flammentempel-Gang'),
	(728, 2, 'Special Ops: Dragon\'s Gullet', 'Spezialeinsatz: Drachenschlund'),
	(729, 2, 'Special Ops: Grendich Courthouse', 'Spezialeinsatz: Gerichtsgebäude in Grendich'),
	(770, 9, 'The Tengu Accords', 'Das Friedensabkommen mit den Tengu'),
	(771, 14, 'The Battle of Jahai', 'Die Schlacht von Jahai'),
	(772, 2, 'The Flight North', 'Die Flucht nach Norden'),
	(773, 4, 'The Rise of the White Mantle', 'Der Aufstieg des Weißen Mantels'),
	(781, 21, 'Secret Lair of the Snowmen', 'Der geheime Unterschlupf der Schneemänner'),
	(782, 21, 'Secret Lair of the Snowmen', 'Der geheime Unterschlupf der Schneemänner'),
	(783, 7, 'Droknar\'s Forge (Epilogue)', 'Droknars Schmiede (Epilog)'),
	(788, 4, 'Temple of the Ages', 'Tempel der Zeitalter'),
	(789, 10, 'Deactivating P.O.X.', 'P.O.X. deaktivieren'),
	(790, 15, 'Deactivating N.O.X.', 'N.O.X. deaktivieren'),
	(791, 21, 'Secret Underground Lair', 'Geheimes unterirdisches Versteck'),
	(792, 21, 'Golem Tutorial Simulation', 'Golem-Tutoriumssimulation'),
	(793, 18, 'Ice Cliff Chasms (snowball)', 'Eisklippen-Abgründe (Schneeball-Dominanz)'),
	(794, 22, 'Zaishen Menagerie Grounds', 'Zaishen-Menageriegelände'),
	(806, 23, 'The Underworld (Something Wicked This Way Comes)', 'Die Unterwelt (Etwas Böses kommt des Weges)'),
	(807, 23, 'The Underworld (Don\'t Fear the Reapers)', 'Die Unterwelt (Keine Angst vor den Schnittern)'),
	(837, 4, 'Talmark Wilderness (War in Kryta)', 'Talmark-Wildnis (Krieg in Kryta)'),
	(838, 20, 'Trial of Zinn', 'Zinn vor Gericht'),
	(839, 4, 'Divinity Coast', 'Küste der Göttlichkeit'),
	(840, 4, 'Lion\'s Arch Keep', 'Burgfried von Löwenstein'),
	(841, 4, 'D\'Alessio Seaboard', 'D\'Alessio-Küste'),
	(842, 4, 'The Battle for Lion\'s Arch', 'Die Schlacht um Löwenstein'),
	(843, 4, 'Riverside Province', 'Flussuferprovinz'),
	(844, 4, 'Lion\'s Arch (Epilogue)', 'Löwenstein (Epilog)'),
	(845, 21, 'The Mausoleum', 'Das Mausoleum'),
	(846, 4, 'Rise', 'Aufstand'),
	(847, 4, 'Shadows in the Jungle', 'Schatten im Dschungel'),
	(848, 4, 'A Vengeance of Blades', 'Eine klingende Vergeltung'),
	(849, 4, 'Auspicious Beginnings', 'Verheißungsvoller Beginn'),
	(854, 18, 'Olafstead', 'Olafsheim'),
	(855, 3, 'The Great Snowball Fight of the Gods (Operation: Crush Spirits)', 'Die große Schneeballschlacht der Götter'),
	(856, 3, 'The Great Snowball Fight of the Gods (Fighting in a Winter Wonderland)', 'Die große Schneeballschlacht der Götter'),
	(860, 10, 'What Waits in Shadow', 'Was im Schatten lauert'),
	(861, 10, 'A Chance Encounter', 'Ein zufälliges Treffen'),
	(862, 10, 'Tracking the Corruption', 'Der Verdorbenheit auf der Spur'),
	(863, 10, 'Cantha Courier Crisis', 'Canthanische Kurierkrise'),
	(864, 9, 'A Treaty\'s a Treaty', 'Ein Vertrag ist ein Vertrag'),
	(865, 9, 'Deadly Cargo', 'Tödliche Fracht'),
	(866, 10, 'The Rescue Attempt', 'Der Rettungsversuch'),
	(867, 10, 'Violence in the Streets', 'Gewalt auf den Straßen'),
	(869, 10, 'Calling All Thugs', 'Aufruf an alle Schurken'),
	(870, 10, 'Finding Jinnai', 'Suche nach Jinnai'),
	(871, 9, 'Raid on Shing Jea Monastery', 'Überfall auf das Kloster von Shing Jea'),
	(872, 10, 'Raid on Kaineng Center', 'Überfall auf Kaineng'),
	(873, 10, 'Ministry of Oppression', 'Ministerium der Unterdrückung'),
	(874, 10, 'The Final Confrontation', 'Die letzte Gegenüberstellung'),
	(875, 1, 'Lakeside County: 1070 AE', 'Seeufer-Grafschaft: 1070 N.E.'),
	(876, 1, 'Ashford Catacombs: 1070 AE', 'Aschfurt-Katakomben: 1070 N.E.');
