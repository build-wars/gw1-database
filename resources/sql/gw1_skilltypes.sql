CREATE TABLE IF NOT EXISTS `gw1_skilltypes` (
  `id`      TINYINT(2)          NOT NULL,
  `name_de` TINYTEXT
            COLLATE utf8mb4_bin NOT NULL,
  `name_en` TINYTEXT
            COLLATE utf8mb4_bin NOT NULL,
  `abbr`    TINYTEXT
            COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


INSERT INTO `gw1_skilltypes` (`id`, `name_de`, `name_en`, `abbr`) VALUES
  (0, 'Keine Fertigkeit', 'Not a Skill', 'nos'),
  (1, 'Fertigkeit', 'Skill', 'sk'),
  (2, 'Bogenangriff', 'Bow Attack', 'bo'),
  (3, 'Nahkampfangriff', 'Melee Attack', 'me'),
  (4, 'Axtangriff', 'Axe Attack', 'ax'),
  (5, 'Leithandangriff', 'Lead Attack', 'le'),
  (6, 'Begleithandangriff', 'Off-Hand Attack', 'of'),
  (7, 'Doppelangriff', 'Dual Attack', 'du'),
  (8, 'Hammerangriff', 'Hammer Attack', 'ha'),
  (9, 'Sensenangriff', 'Scythe Attack', 'sc'),
  (10, 'Schwertangriff', 'Sword Attack', 'sw'),
  (11, 'Tiergefährtenangriff', 'Pet Attack', 'pe'),
  (12, 'Speerangriff', 'Spear Attack', 'spea'),
  (13, 'Anfeuerungsruf', 'Chant', 'ch'),
  (14, 'Echo', 'Echo', 'ec'),
  (15, 'Form', 'Form', 'fo'),
  (16, 'Glyphe', 'Glyph', 'gl'),
  (17, 'Vorbereitung', 'Preparation', 'pr'),
  (18, 'Binderitual', 'Binding ritual', 'bi'),
  (19, 'Naturritual', 'Nature ritual', 'na'),
  (20, 'Schrei', 'Shout', 'sh'),
  (21, 'Siegel', 'Signet', 'si'),
  (22, 'Zauber', 'Spell', 'sp'),
  (23, 'Verzauberung', 'Enchantment spell', 'en'),
  (24, 'Verhexung', 'Hex Spell', 'he'),
  (25, 'Gegenstandszauber', 'Item Spell', 'it'),
  (26, 'Abwehrzauber', 'Ward Spell', 'wa'),
  (27, 'Waffenzauber', 'Weapon Spell', 'wea'),
  (28, 'Brunnenzauber', 'Well Spell', 'we'),
  (29, 'Haltung', 'Stance', 'st'),
  (30, 'Falle', 'Trap', 'tr'),
  (31, 'Distanzangriff', 'Ranged attack', 'ra'),
  (32, 'Ebon-Vorhut-Ritual', 'Ebon Vanguard Ritual', 'eb'),
  (33, 'Blitzverzauberung', 'Flash Enchantment', 'fl'),
  (34, 'Doppelverzauberung', 'Double Enchantment', 'do');
