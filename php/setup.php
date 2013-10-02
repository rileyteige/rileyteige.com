<?php

require_once 'Slim/Slim/Slim.php';
require_once 'templates/templates/setup.php';

require_once 'helpers.php';
require_once 'resources.php';

\Slim\Slim::registerAutoloader();

register_helpers();
register_resources();

function load_templated_page($page, $master = 'master.html') {
	return \templates\load_templated_page($page, $master);
}
?>