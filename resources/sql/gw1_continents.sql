CREATE TABLE `gw1_continents` (
	`continent_id` tinyint(2) UNSIGNED NOT NULL,
	`shortname`    tinytext            NOT NULL,
	`rect`         tinytext            NOT NULL,
	`name_en`      tinytext            NOT NULL,
	`name_de`      tinytext            NOT NULL,
	PRIMARY KEY (`continent_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_continents` (`continent_id`, `shortname`, `rect`, `name_en`, `name_de`) VALUES
	(1, 'mists', '[[0, 0], [0, 0]]', 'The Mists', 'Die Nebel'),
	(2, 'tyria', '[[0, 0], [32766, 36944]]', 'Tyria', 'Tyria'),
	(3, 'cantha', '[[0, 0], [24648, 18488]]', 'Cantha', 'Cantha'),
	(4, 'elona', '[[0, 0], [24640, 18480]]', 'Elona', 'Elona'),
	(5, 'presearing', '[[0, 0], [8190, 6160]]', 'Tyria (pre-Searing)', 'Tyria (vor dem Feuer)'),
	(6, 'battleisles', '[[0, 0], [8190, 6160]]', 'Battle Isles', 'Kampfarchipel');
