<?php

require_once 'lib/Slim/Slim/Slim.php';

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

class Router
{
	function __construct() {
		$this->slimRouter = new \Slim\Slim();
	}

	public function get($route, $routeHandler) {
		$this->registerSlimRoute($route, $routeHandler, 'get');
	}

	public function post($route, $routeHandler) {
		$this->registerSlimRoute($route, $routeHandler, 'post');
	}

	public function processRoute() {
		$this->slimRouter->run();
	}

	private function registerSlimRoute($route, $routeHandler, $slimFunction) {
		$registerGet = function($route, $routeHandler, $slimFunction) {
			if (!endsWith($route, '/') && !endsWith($route, '(/)')) {
				$route .= '(/)';
			}

			$this->slimRouter->$slimFunction($route, $routeHandler);
		};

		if (is_array($route)) {
			foreach ($route as $r) {
				$registerGet($r, $routeHandler, $slimFunction);
			}
		} else {
			$registerGet($route, $routeHandler, $slimFunction);
		}
	}
}

\Slim\Slim::registerAutoloader();

?>