<?php

namespace Teige\Util;

require_once '/php/lib/templates/templates/setup.php';

/*
 * Provides utility methods for handling templated pages.
 */
class PageTemplateHelper
{
	/*
	 * Loads a page with a template, specified by a master page.
	 */
	public static function loadPageTemplate($page, $master = 'master.html') {
		return \templates\load_templated_page($page, $master);
	}

	public static function applyModel($model, $pageTemplate) {
		return \templates\apply_model($model, $pageTemplate);
	}
}

?>