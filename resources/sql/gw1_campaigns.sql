CREATE TABLE IF NOT EXISTS `gw1_campaigns` (
  `id`      TINYINT(1) UNSIGNED NOT NULL,
  `name_de` TINYTEXT            NOT NULL,
  `name_en` TINYTEXT            NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


INSERT INTO `gw1_campaigns` (`id`, `name_de`, `name_en`) VALUES
  (0, 'Basis', 'Core'),
  (1, 'Prophecies', 'Prophecies'),
  (2, 'Factions', 'Factions'),
  (3, 'Nightfall', 'Nightfall'),
  (4, 'Eye of the North', 'Eye of the North');
