<?php

namespace Teige;

require_once 'constants.php';

$defaultResources = [
	'HelloWorld' => 'Hello, world!',
	Constants::PageHeaderTitle => 'Software Engineer, Student Pilot',
	Constants::MainImageUrl => '/static/images/cessna.jpg'
];

class ResourceManager
{
	function __construct($resources = []) {
		global $defaultResources;

		$this->resources = array_merge($defaultResources, $resources);
	}

	public static function current() {
		return Application::current()->resourceManager;
	}

	public function register() {
		foreach ($this->resources as $key => $val) {
			\templates\resource($key, $val);
		}
	}

	public function getResource($key) {
		if (!array_key_exists($key, $this->resources)) {
			throw new Exception("Key not found.");
		}
		
		return $this->resources[$key];
	}
}

?>