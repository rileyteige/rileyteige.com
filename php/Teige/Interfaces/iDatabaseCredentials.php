<?php

namespace Teige\Interfaces;

interface IDatabaseCredentials
{
	public function username();
	public function password();
	public function databaseName();
}

?>