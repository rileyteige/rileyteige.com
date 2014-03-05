<?php

namespace Teige;

require_once '/php/lib/redbean/rb.php';

require_once 'Data/blogRepository.php';

use Teige\Data;

class BlogProvider {
	function __construct($blogRepository) {
		if ($blogRepository == null) {
			throw new Exception("Blog provider cannot be initialized with a null repository.");
		}

		$this->repo = $blogRepository;
	}

	public function createBlogPost($title, $author, $publishDate, $imgUrl, $seoTitle, $contentPath) {
		return $this->repo->createBlogPost(
			$title,
			$author,
			$publishDate,
			$imgUrl,
			$seoTitle,
			$contentPath);
	}

	public function loadBlogPost($blogSeoTitle) {
		$blog = $this->repo->loadBlogPost($blogSeoTitle);
		if ($blog == null) {
			return null;
		}

		Application::current()->templateManager->setHeroImage($blog->heroImageUrl);

		return $blog;
	}

	public function loadRecentBlogs($numBlogs) {
		return $this->repo->loadRecentBlogs($numBlogs);
	}
}

?>