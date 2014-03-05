<?php

namespace Teige;

require_once '/php/lib/templates/templates/setup.php';

$defaultHelpers = [
	'LinkLocalPage' => function($doc, $text) {
		return "<a href=\"$doc\">$text</a>";
	},
	
	'Css' => function($filepath) {
		return '<link rel="stylesheet" type="text/css" href="/css/'.$filepath.'">';
	},

	'Script' => function($filepath) {
		return '<script type="text/javascript" src="/js/'.$filepath.'"></script>';
	},

	'MainImageUrl' => function() {
		return Application::current()->templateManager->heroImage;
	}
];

class TemplateManager
{
	function __construct($helperMethods = []) {
		global $defaultHelpers;

		$this->helperMethods = array_merge($defaultHelpers, $helperMethods);
		$this->heroImage = Application::current()->resourceManager->getResource(MAIN_IMAGE_URL);
	}

	function registerHelperMethods() {
		foreach ($this->helperMethods as $name => $fn) {
			\templates\register_helper($name, $fn);
		}
	}

	function setHeroImage($imageUrl) {
		$this->heroImage = $imageUrl;
	}
}

?>