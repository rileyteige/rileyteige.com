<?php

require_once 'markdown/Michelf/Markdown.php';
require_once 'Slim/Slim/Slim.php';
require_once 'redbean/rb.php';
require_once 'templates/templates/setup.php';

require_once 'globals.php';
require_once 'blog.php';
require_once 'helpers.php';
require_once 'sqlcreds.php';
require_once 'resources.php';

\Slim\Slim::registerAutoloader();

R::setup('sqlite:rileyteige.db', SQL_DB_USER, SQL_DB_PASS);

register_helpers();
register_resources();

function load_templated_page($page, $master = 'master.html') {
	return \templates\load_templated_page($page, $master);
}

function http_get_request_body() {
	return @file_get_contents('php://input');
}
?>