CREATE TABLE `gw1_regions` (
	`region_id`    tinyint(2) UNSIGNED NOT NULL,
	`continent_id` tinyint(2) UNSIGNED NOT NULL,
	`campaign_id`  tinyint(1) UNSIGNED NOT NULL,
	`rect`         tinytext            NOT NULL,
	`name_de`      tinytext            NOT NULL,
	`name_en`      tinytext            NOT NULL,
	PRIMARY KEY (`region_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_regions` (`region_id`, `continent_id`, `campaign_id`, `rect`, `name_de`, `name_en`) VALUES
	(1, 5, 2, '[[0,0],[0,0]]', 'Ascalon (Tutorial)', 'Ascalon (Tutorial)'),
	(2, 2, 2, '[[0,0],[0,0]]', 'Ascalon', 'Ascalon'),
	(3, 2, 2, '[[0,0],[0,0]]', 'Nördliche Zittergipfel', 'Northern Shiverpeaks'),
	(4, 2, 2, '[[0,0],[0,0]]', 'Kryta', 'Kryta'),
	(5, 2, 2, '[[0,0],[0,0]]', 'Maguuma-Dschungel', 'Maguuma Jungle'),
	(6, 2, 2, '[[0,0],[0,0]]', 'Kristallwüste', 'Crystal Desert'),
	(7, 2, 2, '[[0,0],[0,0]]', 'Südliche Zittergipfel', 'Southern Shiverpeaks'),
	(8, 2, 2, '[[0,0],[0,0]]', 'Feuerring-Inselkette', 'Ring of Fire Islands'),
	(9, 3, 3, '[[0,0],[0,0]]', 'Insel Shing Jea', 'Shing Jea Island'),
	(10, 3, 3, '[[0,0],[0,0]]', 'Stadt Kaineng', 'Kaineng City'),
	(11, 3, 3, '[[0,0],[0,0]]', 'Das Jademeer', 'The Jade Sea'),
	(12, 3, 3, '[[0,0],[0,0]]', 'Echowald', 'Echovald Forest'),
	(13, 4, 4, '[[0,0],[0,0]]', 'Istan', 'Istan'),
	(14, 4, 4, '[[0,0],[0,0]]', 'Kourna', 'Kourna'),
	(15, 4, 4, '[[0,0],[0,0]]', 'Vaabi', 'Vabbi'),
	(16, 4, 4, '[[0,0],[0,0]]', 'Das Ödland', 'The Desolation'),
	(17, 8, 1, '[[0,0],[0,0]]', 'Reich der Qual', 'Realm of Torment'),
	(18, 2, 5, '[[0,0],[0,0]]', 'Ferne Zittergipfel', 'Far Shiverpeaks'),
	(19, 2, 5, '[[0,0],[0,0]]', 'Charr-Heimat', 'Charr Homelands'),
	(20, 2, 5, '[[0,0],[0,0]]', 'Befleckte Küste', 'Tarnished Coast'),
	(21, 7, 5, '[[0,0],[0,0]]', 'Tiefen von Tyria', 'Depths of Tyria'),
	(22, 1, 1, '[[0,0],[0,0]]', 'Kampfarchipel', 'The Battle Isles'),
	(23, 1, 1, '[[0,0],[0,0]]', 'Die Nebel', 'The Mists'),
	(24, 2, 2, '[[0,0],[0,0]]', 'Tyria (Untergrund)', 'Tyria (underground)'),
	(25, 3, 3, '[[0,0],[0,0]]', 'Cantha (Untergrund)', 'Cantha (underground)'),
	(26, 4, 4, '[[0,0],[0,0]]', 'Elona (Untergrund)', 'Elona (underground)');
