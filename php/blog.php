<?php

use \Michelf\Markdown;

function load_markdown($filename) {
	$text = file_get_contents($filename);
	return Markdown::defaultTransform($text);
}

function load_blog_metadata($blogId) {
	return R::load(BLOG, $blogId);
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
	
	
	return load_markdown(BLOG_ENTRY_ROOT.'/'.$blog->contentPath);
}

?>