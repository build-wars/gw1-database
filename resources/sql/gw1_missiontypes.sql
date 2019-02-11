CREATE TABLE `gw1_missiontypes` (
	`missiontype_id` tinyint(2) UNSIGNED NOT NULL,
	`shortname`      tinytext            NOT NULL,
	`name_en`        tinytext            NOT NULL,
	`name_de`        tinytext            NOT NULL,
	PRIMARY KEY (`missiontype_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_missiontypes` (`missiontype_id`, `shortname`, `name_en`, `name_de`) VALUES
	(1, 'arena', 'Arena', 'Arena'),
	(2, 'challenge', 'Challenge mission', 'Herausforderungs-Mission'),
	(3, 'competetive', 'Competitive Mission', 'Kompetitive Mission'),
	(4, 'cooperative', 'Cooperative Mission', 'Kooperative Mission'),
	(5, 'dungeon', 'Dungeon', 'Verlies'),
	(6, 'elite', 'Elite Mission', 'Elite-Mission');
