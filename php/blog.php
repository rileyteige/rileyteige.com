<?php

use \Michelf\Markdown;

function load_markdown($filename) {
	$text = file_get_contents($filename);
	return Markdown::defaultTransform($text);
}

function load_blog_metadata($blogId) {
	$blog = R::load(BLOG, $blogId);

	$publishDate = DateTime::createFromFormat('m/d/Y', $blog->publishDate);
	$blog->publishDate = $publishDate->format('F d, Y');

	return $blog;
}

function create_blog_post($title, $author, $publishDate, $imgUrl, $contentPath) {
	$post = R::dispense(BLOG);
	$post->title = $title;
	$post->author = $author;
	$post->publishDate = $publishDate;
	$post->imageUrl = $imgUrl;
	$post->contentPath = $contentPath;
	
	$id = R::store($post);
	
	return $id;
}

define('BLOG_ENTRY_ROOT', 'static/blog');
function load_blog_post($blogId) {
	$blog = load_blog_metadata($blogId);
	if ($blog == null) {
		return null;
	}
	
	$blog->content = load_markdown(BLOG_ENTRY_ROOT.'/'.$blog->contentPath);
	
	return $blog;
}

?>