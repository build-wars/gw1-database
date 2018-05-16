<?php
/**
 * @filesource   index.php
 * @created      30.04.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GW1DBwww;

use chillerlan\BBCode\BBCode;
use chillerlan\GW1DB\GW1DBOptions;
use chillerlan\GW1DB\GWBBCode\GWBBMiddleware;
use chillerlan\GW1DB\GWBBCode\GWBBOutput;

require_once '../vendor/autoload.php';

$lang = 'de';

$gwbboptions = new GW1DBOptions([
	'outputInterface'           => GWBBOutput::class,
	'parserMiddlewareInterface' => GWBBMiddleware::class,
	'sanitizeInput'             => true,
	'preParse'                  => true,
	'postParse'                 => true,
	'language'                  => $lang,
	'gwdbURL'                   => 'https://smiley.codes/gwdb',
]);

$gwbb = new BBCode($gwbboptions);


header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>GWBBCode test</title>
	<link rel="stylesheet" href="./gwbbcode.css">
</head>
<body>
<?php

echo $gwbb->parse(file_get_contents(__DIR__.'/gwbbcode.txt'));

?>
<script>
	const GWTooltipOptions = {
		gwdbURL: 'https://smiley.codes/gwdb',
		targetSelector: '.gwbb-skill',//, .gwbb-link > .attr
		tooltipID: 'gwbb-tooltip',
		lang:'<?php echo $lang; ?>'
	}
</script>
<script async src="GWTooltip.js"></script>
</body>
</html>
