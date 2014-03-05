<?php

namespace Teige\Util;

class HttpHelper
{
	static function getRequestBody() {
		return @file_get_contents('php://input');
	}
}

?>