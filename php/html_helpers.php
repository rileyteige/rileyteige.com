<?php

$helpers = [
	'LinkLocalPage' => function($doc, $text) {
		return "<a href=\"$doc\">$text</a>";
	},
	
	'Css' => function($filepath) {
		return '<link rel="stylesheet" type="text/css" href="/css/'.$filepath.'">';
	},

	'Script' => function($filepath) {
		return '<script type="text/javascript" src="/js/'.$filepath.'"></script>';
	},

	'MainImageUrl' => function() {
		return get_global(MAIN_IMAGE_URL);
	}
];

function register_html_helpers() {
	global $helpers;
	
	foreach ($helpers as $name => $fn) {
		\templates\register_helper($name, $fn);
	}
}

?>