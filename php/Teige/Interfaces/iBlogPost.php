<?php

namespace Teige\Interfaces;

interface IBlogPost
{
	public function getTitle();
	public function getAuthor();
	public function getPublishDate();
	public function getHeroImageUrl();
	public function getSeoTitle();
	public function getContentPath();
	public function getContent();
}

?>