<?php

use \Michelf\Markdown;

function load_markdown($filename) {
	$text = file_get_contents($filename);
	return Markdown::defaultTransform($text);
}

?>