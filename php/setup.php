<?php

require_once 'lib/markdown/Michelf/Markdown.inc.php';
require_once 'lib/redbean/rb.php';
require_once 'lib/templates/templates/setup.php';

require_once 'globals.php';
require_once 'blog.php';
require_once 'html_helpers.php';
require_once 'sqlcreds.php';
require_once 'resources.php';

R::setup('sqlite:rileyteige.db', SQL_DB_USER, SQL_DB_PASS);

register_html_helpers();
register_resources();

function load_templated_page($page, $master = 'master.html') {
	return \templates\load_templated_page($page, $master);
}

function http_get_request_body() {
	return @file_get_contents('php://input');
}
?>