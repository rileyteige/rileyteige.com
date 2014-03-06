<?php

namespace Teige;

require_once '/php/lib/templates/templates/setup.php';

require_once 'constants.php';

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
		return TemplateManager::current()->heroImage;
	}
];

class TemplateManager
{
	function __construct($helperMethods = []) {
		global $defaultHelpers;

		$this->helperMethods = array_merge($defaultHelpers, $helperMethods);
		$this->heroImage = ResourceManager::current()->getResource(Constants::MainImageUrl);
	}

	public static function current() {
		return Application::current()->templateManager;
	}

	public function registerHelperMethods() {
		foreach ($this->helperMethods as $name => $fn) {
			\templates\register_helper($name, $fn);
		}
	}

	public function setHeroImage($imageUrl) {
		$this->heroImage = $imageUrl;
	}
}

?>