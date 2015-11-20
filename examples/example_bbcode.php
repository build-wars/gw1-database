<?php
/**
 * @filesource   example.php
 * @created      19.09.2015
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

/**
 * I dare you to use this global constant to specify the path to your .env file
 */
const CONFIGDIR = '../config';

require_once '../vendor/autoload.php';

use chillerlan\GW1Database\bbcode\GWBBParser;
use chillerlan\GW1Database\bbcode\GWBBParserOptions;
use chillerlan\GW1Database\bbcode\GWBBParserExtension;
use chillerlan\GW1Database\bbcode\Html5\GWBBHtml5BaseModule;

/*
header('Content-type: text/html;charset=utf-8;');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="css/normalize.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/bbcode.css"/>
	<link rel="stylesheet" href="css/prism-coy.css"/>
	<title>BBCode parser</title>
</head>
<body>
<?php
*/
/**
 * Run
 */

$timer = microtime(true);

// create a new Parser instance

$options = new GWBBParserOptions;
$options->nesting_limit = 10;
$options->allow_all = true;

$gwbbcode = new GWBBParser();
$gwbbcode->set_options($options);

#var_dump($gwbbcode->get_tagmap());
#var_dump($gwbbcode->get_allowed());
#var_dump($gwbbcode->get_noparse());

$content = $gwbbcode->parse(file_get_contents('gwbbcode.txt'));

#echo $content.PHP_EOL;

echo '<!-- bbcode: '.round((microtime(true)-$timer), 5).'s -->'.PHP_EOL;
/*
?>
<!-- let's assume you use a common js framework in your project -->
<script src="//ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js"></script>
<script src="js/prism.js"></script>
<script>
	(function(){
		document.observe('dom:loaded', function(){
			// open/close expanders
			$$('.expander').invoke('observe', 'click', function(){
				Effect.toggle(this.dataset.id, 'blind');
			});

			// force external links to open in a new window
			$$('.ext-href').invoke('observe', 'click', function(ev){
				Event.stop(ev);
				window.open(this.readAttribute('href'));
			});

			// yada yada yada
		});
	})()
</script>
</body>
</html>
<?php
*/