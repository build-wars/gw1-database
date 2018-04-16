CREATE TABLE IF NOT EXISTS `gw1_professions` (
  `id`       TINYINT(2)          NOT NULL,
  `name_de`  TINYTEXT            NOT NULL,
  `name_en`  TINYTEXT            NOT NULL,
  `abbr_de`  TINYTEXT            NOT NULL,
  `abbr_en`  TINYTEXT            NOT NULL,
  `desc_de`  TEXT                NOT NULL,
  `desc_en`  TEXT                NOT NULL,
  `armor`    TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
  `bonus_de` TINYTEXT            NOT NULL,
  `bonus_en` TINYTEXT            NOT NULL,
  `chest_de` TINYTEXT            NOT NULL,
  `chest_en` TINYTEXT            NOT NULL,
  `hand_de`  TINYTEXT            NOT NULL,
  `hand_en`  TINYTEXT            NOT NULL,
  `leg_de`   TINYTEXT            NOT NULL,
  `leg_en`   TINYTEXT            NOT NULL,
  `foot_de`  TINYTEXT            NOT NULL,
  `foot_en`  TINYTEXT            NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

INSERT INTO `gw1_professions` (`id`, `name_de`, `name_en`, `abbr_de`, `abbr_en`, `desc_de`, `desc_en`, `armor`, `bonus_de`, `bonus_en`, `chest_de`, `chest_en`, `hand_de`, `hand_en`, `leg_de`, `leg_en`, `foot_de`, `foot_en`)
VALUES
  (0, 'keine', 'none', 'X', 'X', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
  (1, 'Krieger', 'Warrior', 'K', 'W', '', '', 80, 'Rüstung +20 (gg. körperlichen Schaden)', 'Armor +20 (vs. physical damage)', '', '', '', '', '', '', '', ''),
  (2, 'Waldläufer', 'Ranger', 'W', 'R', '', '', 70, 'Rüstung +30 (gg. Elementarschaden)', 'Armor +30 (vs. elemental damage)', 'Energie +5', 'Energy +5', '', '', 'Energierückgewinnung +1', 'Energy recovery +1', '', ''),
  (3, 'Mönch', 'Monk', 'Mö', 'Mo', '', '', 60, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (4, 'Nekromant', 'Necromancer', 'N', 'N', '', '', 60, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (5, 'Mesmer', 'Mesmer', 'Me', 'Me', '', '', 60, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (6, 'Elementarmagier', 'Elementalist', 'E', 'E', '', '', 60, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (7, 'Assassine', 'Assassin', 'A', 'A', '', '', 70, '', '', 'Energie +5', 'Energy +5', '', '', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (8, 'Ritualist', 'Ritualist', 'R', 'Rt', '', '', 60, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1'),
  (9, 'Paragon', 'Paragon', 'P', 'P', '', '', 80, '', '', 'Energie +5', 'Energy +5', 'Energie +5', 'Energy +5', '', '', '', ''),
  (10, 'Derwisch', 'Dervish', 'D', 'D', '', '', 70, '', '', 'Lebenspunkte +25', 'Health +25', 'Energie +5', 'Energy +5', 'Energierückgewinnung +1', 'Energy recovery +1', 'Energierückgewinnung +1', 'Energy recovery +1');
