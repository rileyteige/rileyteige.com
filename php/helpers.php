<?php

$helpers = [
	'LinkLocalPage' => function($doc, $text) {
		return "<a href=\"$doc\">$text</a>";
	}
];

function register_helpers() {
	global $helpers;
	
	foreach ($helpers as $name => $fn) {
		\templates\register_helper($name, $fn);
	}
}

?>