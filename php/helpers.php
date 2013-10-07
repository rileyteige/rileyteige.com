<?php

$helpers = [
	'LinkLocalPage' => function($doc, $text) {
		return "<a href=\"$doc\">$text</a>";
	},
	
	'Css' => function($filepath) {
		return '<link rel="stylesheet" type="text/css" href="/rileyteige.com/css/'.$filepath.'">';
	}
];

function register_helpers() {
	global $helpers;
	
	foreach ($helpers as $name => $fn) {
		\templates\register_helper($name, $fn);
	}
}

?>