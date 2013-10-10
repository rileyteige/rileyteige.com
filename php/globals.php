<?php

define('BLOG', 'blog');

define('MAIN_IMAGE_URL', 'main_image_url');

$config = [
	MAIN_IMAGE_URL => 'http://wallike.com/wp-content/uploads/2013/07/Wooden-Chess-Pictures.jpg'
];

function get_global($key) {
	global $config;

	return $config[$key];
}

function set_global($key, $value) {
	global $config;

	$config[$key] = $value;
}

?>