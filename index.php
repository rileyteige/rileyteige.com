<?php

require_once 'php/setup.php';

$app = new \Slim\Slim();

\templates\resource('HelloWorld', 'Hello, world!');

$app->get('/', function() {
	$page = load_templated_page('index.html');

	echo $page;
});


$app->get('/:page', function($page) {
	if (strpos($page, '.html') == FALSE) {
		$page = "$page.html";
	}
	
	$html = load_templated_page($page);
	
	echo $html;
});

$app->run();

?>