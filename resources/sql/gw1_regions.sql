CREATE TABLE `gw1_regions` (
	`id`        smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
	`continent` tinyint(1)  UNSIGNED NOT NULL DEFAULT '0',
	`name_de`   tinytext             NOT NULL,
	`name_en`   tinytext             NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE=InnoDB
	DEFAULT CHARSET=utf8mb4
	COLLATE=utf8mb4_bin;

INSERT INTO `gw1_regions` (`id`, `continent`, `name_de`, `name_en`) VALUES
	(1, 1, 'Ascalon (Tutorial)', 'Ascalon (pre-Searing)'),
	(2, 1, 'Ascalon', 'Ascalon'),
	(3, 1, 'Nördliche Zittergipfel', 'Northern Shiverpeaks'),
	(4, 1, 'Kryta', 'Kryta'),
	(5, 1, 'Maguuma-Dschungel', 'Maguuma Jungle'),
	(6, 1, 'Kristallwüste', 'Crystal Desert'),
	(7, 1, 'Südliche Zittergipfel', 'Southern Shiverpeaks'),
	(8, 1, 'Feuerring-Inselkette', 'Ring of Fire Islands'),
	(9, 2, 'Insel Shing Jea', 'Shing Jea Island'),
	(10, 2, 'Stadt Kaineng', 'Kaineng City'),
	(11, 2, 'Das Jademeer', 'The Jade Sea'),
	(12, 2, 'Echowald', 'Echovald Forest'),
	(13, 3, 'Istan', 'Istan'),
	(14, 0, 'Kourna', 'Kourna'),
	(15, 0, 'Vaabi', 'Vabbi'),
	(16, 0, 'Das Ödland', 'The Desolation'),
	(17, 0, 'Reich der Qual', 'Realm of Torment'),
	(18, 0, 'Ferne Zittergipfel', 'Far Shiverpeaks'),
	(19, 0, 'Charr-Heimat', 'Charr Homelands'),
	(20, 0, 'Befleckte Küste', 'Tarnished Coast'),
	(21, 0, 'Tiefen von Tyria', 'Depths of Tyria'),
	(22, 0, 'Die Nebel', 'The Mists'),
	(23, 0, 'Kampfarchipel', 'The Battle Isles');
