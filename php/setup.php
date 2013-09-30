<?php

require_once 'Slim/Slim/Slim.php';
require_once 'templates/templates/setup.php';

\Slim\Slim::registerAutoloader();

function load_templated_page($page, $master = 'master.html') {
	return \templates\load_templated_page($page, $master);
}
?>