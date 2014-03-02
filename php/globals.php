<?php

define('BLOG', 'blog');

define('MAIN_IMAGE_URL', 'main_image_url');

define('PAGE_HEADER_TITLE', 'PageHeaderTitle');

$config = [
	MAIN_IMAGE_URL => '/static/images/cessna.jpg'
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