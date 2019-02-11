CREATE TABLE `gw1_campaigns` (
	`campaign_id`  tinyint(1) UNSIGNED NOT NULL,
	`continent_id` tinyint(2) UNSIGNED NOT NULL,
	`name_de`      tinytext            NOT NULL,
	`name_en`      tinytext            NOT NULL,
	PRIMARY KEY (`campaign_id`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_bin;

INSERT INTO `gw1_campaigns` (`campaign_id`, `continent_id`, `name_de`, `name_en`) VALUES
	(1, 1, 'Basis', 'Core'),
	(2, 2, 'Prophecies', 'Prophecies'),
	(3, 3, 'Factions', 'Factions'),
	(4, 4, 'Nightfall', 'Nightfall'),
	(5, 2, 'Eye of the North', 'Eye of the North');
