<?php

namespace Teige\Models;

require_once '/php/lib/markdown/Michelf/Markdown.inc.php';

require_once '/php/Teige/Interfaces/iBlogPost.php';

use \Michelf\Markdown;
use Teige\Interfaces;

class MarkdownPost implements Interfaces\IBlogPost
{
	function __construct($title, $author, $publishDate, $heroImageUrl, $seoTitle, $contentPath) {
		$this->title = $title;
		$this->author = $author;
		$this->publishDate = \DateTime::createFromFormat('m/d/Y', $publishDate)->format('M d, Y');
		$this->heroImageUrl = $heroImageUrl;
		$this->seoTitle = $seoTitle;
		$this->contentPath = $contentPath;
		$this->content = Markdown::defaultTransform(file_get_contents('static/blog/'.$contentPath));
	}

	public function getTitle() { return $this->title; }
	public function getAuthor() { return $this->author; }
	public function getPublishDate() { return $this->publishDate; }
	public function getHeroImageUrl() { return $this->heroImageUrl; }
	public function getSeoTitle() { return $this->seoTitle; }
	public function getContentPath() { return $this->contentPath; }
	public function getContent() { return $this->content; }
}

?>