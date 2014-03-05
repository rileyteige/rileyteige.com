<?php

namespace Teige\Interfaces;

interface IRouter
{
	public function get($route, $routeHandler);
	public function post($route, $routeHandler);
	public function processRoute();
}

?>