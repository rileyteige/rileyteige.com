<?php

namespace Teige;

$defaultResources = [
	'HelloWorld' => 'Hello, world!',
	PAGE_HEADER_TITLE => 'Software Engineer, Student Pilot',
	MAIN_IMAGE_URL => '/static/images/cessna.jpg'
];

class ResourceManager
{
	function __construct($resources = []) {
		global $defaultResources;

		$this->resources = array_merge($defaultResources, $resources);
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