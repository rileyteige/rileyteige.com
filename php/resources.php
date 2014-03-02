<?php

$resources = [
	'HelloWorld' => 'Hello, world!',
	PAGE_HEADER_TITLE => 'Software Engineer, Student Pilot',
];

function register_resources() {
	global $resources;
	
	foreach ($resources as $key => $val) {
		\templates\resource($key, $val);
	}
}

function set_resource($key, $value) {
	\templates\resource($key, $value);
}

function get_resource($key) {
	return \templates\get_resource($key);
}

?>