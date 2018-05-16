# resources readme

## build-common.php
Loads all common dependencies like database, logger, cache and http client and sets
common variables/constants

## build-skill-update.php
Fetches the skilldata from the paw•ned² source and creates the tables `SKILLDATA` and `SKILLDESC_{$lang}`

## build-skill-short-desc.php
Fetches the skill short descriptions from the de/en wikis and updates `SKILLDESC_{$lang}`

## build-skilldb.php
Creates `/src/Data/GWSkillDB.php`, `/public/gwdb/json/skills/*.json` and `/public/gwdb/json/skilldb.json`

## build-skill-images.php
Creates the skill images in several sizes from the hi-res sealed-deck cards dataset (not necessary if you use your own iconset)

## build-itemdb.php
Creates `/src/Data/GWItemDB.php`, `/public/gwdb/json/items/*.json` and `/public/gwdb/json/itemdb.json`

## build-moddb.php
Creates `/src/Data/GWModDB.php`, `/public/gwdb/json/mods/*.json` and `/public/gwdb/json/moddb.json`

## build-class-attr-lookup.php, build-class-prof-lookup.php, build-class-skill-lookup.php

Creates the reverse lookup tables in `/src/Data`: `GWAttrLookup` `GWProfLookup` and `GWSkillLookup`

