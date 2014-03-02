<?php

use \Michelf\Markdown;

function load_markdown_file($filename) {
	$text = file_get_contents($filename);
	return Markdown::defaultTransform($text);
}

function load_blog_metadata($blogSeoTitle) {
	$blog = R::findOne(BLOG, ' seoTitle = ? ', [ $blogSeoTitle ]);

	if ($blog == null) {
		return null;
	}

	$publishDate = DateTime::createFromFormat('m/d/Y', $blog->publishDate);
	$blog->publishDate = $publishDate->format('F d, Y');

	return $blog;
}

function create_blog_post($title, $author, $publishDate, $imgUrl, $seoTitle, $contentPath) {
	$post = R::dispense(BLOG);
	$post->title = $title;
	$post->author = $author;
	$post->publishDate = $publishDate;
	$post->heroImageUrl = $imgUrl;
	$post->seoTitle = $seoTitle;
	$post->contentPath = $contentPath;
	
	$id = R::store($post);
	
	return $id;
}

define('BLOG_ENTRY_ROOT', 'static/blog');
function load_blog_post($blogSeoTitle) {
	$blog = load_blog_metadata($blogSeoTitle);
	if ($blog == null) {
		return null;
	}
	
	$blog->content = load_markdown_file(BLOG_ENTRY_ROOT.'/'.$blog->contentPath);
	
	set_global(MAIN_IMAGE_URL, $blog->heroImageUrl);

	return $blog;
}

// Loads recent blogs, given n.
function load_recent_blogs($numBlogs) {
	$blogRows = R::getAll('SELECT * FROM blog LIMIT ?', [$numBlogs]);
	$blogs = R::convertToBeans('blog', $blogRows);
	return $blogs;
}

?>