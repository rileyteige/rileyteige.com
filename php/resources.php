<?php

$resources = [
	'HelloWorld' => 'Hello, world!',
	'PageHeaderTitle' => 'Riley Teige',
];

function register_resources() {
	global $resources;
	
	foreach ($resources as $key => $val) {
		\templates\resource($key, $val);
	}
}

?>