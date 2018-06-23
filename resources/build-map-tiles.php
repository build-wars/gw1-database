<?php
/**
 * @filesource   build-map-tiles.php
 * @created      19.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBBuild;

use chillerlan\Imagetiler\{Imagetiler, ImagetilerException, ImagetilerOptions};
use ImageOptimizer\OptimizerFactory;

/** @var \Psr\Log\LoggerInterface $logger */
$logger = null;

require_once __DIR__.'/build-common.php';

$utils = __DIR__.'/../../../utils/%s.exe';

$maps = [
	'battleisles',
	'cantha',
	'elona',
	'presearing',
	'tyria',
];

$tilerOptions = new ImagetilerOptions([
	// ImagetilerOptions
	'zoom_min'             => 0,
	'zoom_max'             => 8,
	'zoom_normalize'       => 6,
	'tms'                  => false,
	'fill_color'           => '#000000',
	'fast_resize'          => false,
	'overwrite_base_image' => false,
	'overwrite_tile_image' => true,
	'clean_up'             => false,
	'optimize_output'      => true,
	'memory_limit'         => '12G',
]);

$optimizer_settings = [
	'execute_only_first_png_optimizer' => false,
	'advpng_bin'                       => sprintf($utils, 'advpng'),
	'optipng_bin'                      => sprintf($utils, 'optipng'),
	'pngcrush_bin'                     => sprintf($utils, 'pngcrush'),
	'pngquant_bin'                     => sprintf($utils, 'pngquant'),
];

$optimizer = (new OptimizerFactory($optimizer_settings, $logger))->get('png');
$map_tiler = new Imagetiler($tilerOptions, $optimizer, $logger);

foreach($maps as $map){

	try{
		$map_tiler->process(__DIR__.'/img/maps/'.$map.'.png', __DIR__.'/tiles/'.$map);
	}
	catch(ImagetilerException $e){
		echo $e->getMessage();
		echo $e->getTraceAsString();
	}

}





