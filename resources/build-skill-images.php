<?php
/**
 * @filesource   build-skill-images.php
 * @created      14.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 *
 * @link http://web.archive.org/web/20140831204448/http://www.guildwarsguru.com/forum/king-size-skill-icons-t10295191.html
 *
 * download the hi-res skill images from:
 * @link http://sites.google.com/site/hatvandp/sbs/gw_icons_ame.zip (assassin - mesmer)
 * @link http://sites.google.com/site/hatvandp/sbs/gw_icons_mop.zip (monk - paragon)
 * @link http://sites.google.com/site/hatvandp/sbs/gw_icons_rw.zip (ranger - warrior)
 *
 * note: the name of the image for Empathic Removal contains a typo and
 *       it will trigger a warning if you don't fix it before processing
 *
 * or download the fixed imageset from
 * @link https://chillerlan.de/downloads/gw-skill-images-original.zip
 *
 * note: these imagesets don't contain the pve skill images! (1234 of 1320 images)
 *
 * see also sealed play cards:
 * @link http://web.archive.org/web/20110726192747/http://guildwars.com/competitive/sealedplay/
 * @link http://web.archive.org/web/20111225175519/http://guildwars.com/competitive/sealedplay/cardsdownload.php
 * @link ftp://ftp.guildwars.com/downloads/sealedplaycards-fullset.zip
 */

namespace chillerlan\GW1DBBuild;

/** @var \chillerlan\Database\Database $db */
use chillerlan\Database\ResultInterface;

$db = null;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/build-common.php';

$db->select
	->cols([
		'id'    => ['skilldata.id'],
		'elite' => ['skilldata.elite'],
		'name'  => ['skilldesc.pve_name', 'lower'],
		'prof'  => ['professions.name_en', 'lower'],
	])
	->from([
		'skilldata'   => TABLE_SKILLDATA,
		'skilldesc'   => TABLE_SKILLDESC_EN,
		'professions' => TABLE_PROFESSIONS,
	])
	->where('skilldata.profession', 0, '!=')
	->where('skilldata.rp', 0)
	->where('skilldesc.id', 'skilldata.id', '=', false)
	->where('professions.id', 'skilldata.profession', '=', false)
	->orderBy([
		'skilldata.profession' => 'asc',
		'skilldata.campaign'   => 'asc',
	])
	->query('id')
	->__each(function(ResultInterface $skill, $id) use ($logger){

		// strip any unwanted/illegal characters and replace spaces with underscores
		$skillname = str_replace(['!', '\'', '"', ',', '.', ' '], ['', '', '', '', '', '_'], $skill->name);
		$icon      = imagecreatefromjpeg(SKILLIMG_ORIG.'/'.$skill->prof.'/'.$skillname.'.jpg');

		// create a 14px wide border around the elite skills (#ffb500)
		$size    = 247; //(bool)$skill->elite ? 276 : 248;
		$cropped = imagecreatetruecolor($size, $size);

#		if((bool)$skill->elite){
#			imagefilledrectangle($cropped, 0, 0, 276, 276, imagecolorallocate($cropped, 255, 181, 0));
#			imagecopy($cropped, $icon, 14, 14, 4, 3, 248, 248);
#		}
#		else{
			imagecopy($cropped, $icon, 0, 0, 4, 3, $size, $size);
#		}

		// uncomment if you want to save the cropped original size images
#		imagepng($cropped, __DIR__.'/img/skills/cropped/'.$id.'.png', 9);

		foreach([32, 64, 128, 256] as $thumbsize){
			$path = DIR_IMG.'/skills/'.$thumbsize.'/'.$id;

			$thumb = imagecreatetruecolor($thumbsize, $thumbsize);
			imagecopyresampled($thumb, $cropped, 0, 0, 0, 0, $thumbsize, $thumbsize, $size, $size);
			// you may want to run the processed png-images through something like png-gauntlet to optimize
#			imagepng($thumb, $path.'.png', 9);
#			imagejpeg($thumb, $path.'.jpg', 95);
			imagedestroy($thumb);
		}

		imagedestroy($cropped);

		$logger->info($skill->name);
	})
;

// @todo: resize pve skill images

### script end ###
