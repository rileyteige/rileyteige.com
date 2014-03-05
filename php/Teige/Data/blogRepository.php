<?php

namespace Teige\Data;

require_once '/php/lib/redbean/rb.php';

class BlogRepository
{
	const BLOG = 'blog';

	public function createBlogPost($title, $author, $publishDate, $imgUrl, $seoTitle, $contentPath) {
		$post = \R::dispense(BLOG);
		$post->title = $title;
		$post->author = $author;
		$post->publishDate = $publishDate;
		$post->heroImageUrl = $imgUrl;
		$post->seoTitle = $seoTitle;
		$post->contentPath = $contentPath;
		
		$id = \R::store($post);
		
		return $id;
	}

	public function loadBlogPost($blogSeoTitle) {
		return \R::findOne(BLOG, ' seoTitle = ? ', [ $blogSeoTitle ]);
	}

	public function loadRecentBlogs($numBlogs) {
		$blogRows = \R::getAll('SELECT * FROM '.BLOG.' LIMIT ?', [$numBlogs]);
		$blogs = \R::convertToBeans(BLOG, $blogRows);
		return $blogs;
	}
}

?>