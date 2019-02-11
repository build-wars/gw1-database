CREATE TABLE `gw1_outposttypes` (
	`outposttype_id` tinyint(2) UNSIGNED NOT NULL,
	`shortname`      tinytext            NOT NULL,
	`name_en`        tinytext            NOT NULL,
	`name_de`        tinytext            NOT NULL,
	PRIMARY KEY (`outposttype_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_outposttypes` (`outposttype_id`, `shortname`, `name_en`, `name_de`) VALUES
	(1, 'town', 'Town', 'Stadt'),
	(2, 'outpost', 'Outpost', 'Außenposten'),
	(3, 'missionOutpost', 'Mission outpost', 'Missionsaußenposten'),
	(4, 'arenaOutpost', 'Arena outpost', 'Arenaaußenposten'),
	(5, 'challengeMissionOutpost', 'Challenge mission outpost', 'Missionsaußenposten (Herausforderungs-Mission)'),
	(6, 'eliteMissionOutpost', 'Elite mission outpost', 'Elitemissionsaußenposten'),
	(7, 'guildhall', 'Guild hall', 'Gildenhalle'),
	(8, 'competetiveMissionOutpost', 'Competetive mission outpost', 'Missionsaußenposten (Kompetitive Mission)');
