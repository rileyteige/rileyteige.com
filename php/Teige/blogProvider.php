<?php

namespace Teige;

require_once '/php/lib/redbean/rb.php';

require_once 'Data/blogRepository.php';
require_once 'Models/markdownPost.php';

use Teige\Data;
use Teige\Models;

/*
 * Provides blog data and business logic.
 */
class BlogProvider {
	function __construct($blogRepository) {
		if ($blogRepository == null) {
			throw new Exception("Blog provider cannot be initialized with a null repository.");
		}

		$this->repo = $blogRepository;
	}

	/*
	 * Creates a blog post given the necessary metadata.
	 */
	public function createBlogPost($title, $author, $publishDate, $imgUrl, $seoTitle, $contentPath) {
		return $this->repo->createBlogPost(
			$title,
			$author,
			$publishDate,
			$imgUrl,
			$seoTitle,
			$contentPath);
	}

	/*
	 * Loads a blog post from the database, given its
	 * SEO title.
	 */
	public function loadBlogPost($blogSeoTitle) {
		$rawPost = $this->repo->loadBlogPost($blogSeoTitle);
		if ($rawPost == null) {
			return null;
		}

		$blog = new Models\MarkdownPost(
			$rawPost->title,
			$rawPost->author,
			$rawPost->publishDate,
			$rawPost->heroImageUrl,
			$rawPost->seoTitle,
			$rawPost->contentPath);

		Application::current()->templateManager->setHeroImage($blog->heroImageUrl);

		return $blog;
	}

	/*
	 * Loads the most recent blog posts, given the number
	 * of posts to load.
	 */
	public function loadRecentBlogs($numBlogs) {
		return $this->repo->loadRecentBlogs($numBlogs);
	}
}

?>