CREATE TABLE `gw1_regions` (
	`region_id`    tinyint(2) UNSIGNED NOT NULL,
	`continent_id` tinyint(2) UNSIGNED NOT NULL,
	`campaign_id`  tinyint(1) UNSIGNED NOT NULL,
	`name_de`      tinytext            NOT NULL,
	`name_en`      tinytext            NOT NULL,
	PRIMARY KEY (`region_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_regions` (`region_id`, `continent_id`, `campaign_id`, `name_de`, `name_en`) VALUES
	(1, 5, 2, 'Ascalon (pre)', 'Ascalon (pre)'),
	(2, 2, 2, 'Ascalon', 'Ascalon'),
	(3, 2, 2, 'Nördliche Zittergipfel', 'Northern Shiverpeaks'),
	(4, 2, 2, 'Kryta', 'Kryta'),
	(5, 2, 2, 'Maguuma-Dschungel', 'Maguuma Jungle'),
	(6, 2, 2, 'Kristallwüste', 'Crystal Desert'),
	(7, 2, 2, 'Südliche Zittergipfel', 'Southern Shiverpeaks'),
	(8, 2, 2, 'Feuerring-Inselkette', 'Ring of Fire Islands'),
	(9, 3, 3, 'Insel Shing Jea', 'Shing Jea Island'),
	(10, 3, 3, 'Stadt Kaineng', 'Kaineng City'),
	(11, 3, 3, 'Das Jademeer', 'The Jade Sea'),
	(12, 3, 3, 'Echowald', 'Echovald Forest'),
	(13, 4, 4, 'Istan', 'Istan'),
	(14, 4, 4, 'Kourna', 'Kourna'),
	(15, 4, 4, 'Vaabi', 'Vabbi'),
	(16, 4, 4, 'Das Ödland', 'The Desolation'),
	(17, 4, 1, 'Reich der Qual', 'Realm of Torment'),
	(18, 2, 5, 'Ferne Zittergipfel', 'Far Shiverpeaks'),
	(19, 2, 5, 'Charr-Heimat', 'Charr Homelands'),
	(20, 2, 5, 'Befleckte Küste', 'Tarnished Coast'),
	(21, 2, 5, 'Tiefen von Tyria', 'Depths of Tyria'),
	(22, 1, 1, 'Kampfarchipel', 'The Battle Isles'),
	(23, 1, 1, 'Die Nebel', 'The Mists');
