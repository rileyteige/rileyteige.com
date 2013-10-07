<?php

require_once 'php/setup.php';

$app = new \Slim\Slim();

$app->get('/', function() {
	$page = load_templated_page('index.html');

	echo $page;
});

$app->get('/blog/:blogId', function($blogId) {
	$page = load_templated_page('blog.html');
	
	$blog = load_blog_post($blogId);
	
	if ($blog != null) {
		$page = templates\apply_model($blog, $page);
	}
	
	echo $page;
});

$app->get('/:page', function($page) {
	if (strpos($page, '.html') == FALSE) {
		$page = "$page.html";
	}
	
	$html = load_templated_page($page);
	
	echo $html;
});

$app->post('/blog', function() {
	$body = http_get_request_body();
	if ($body != null) {
		$root = json_decode($body);
		switch($root->type) {
		
			/* CREATE A BLOG */
			case BLOG: {
				$inBlog = $root->content;
				if ($inBlog != null) {
					$blogId = create_blog_post($inBlog->title, $inBlog->author, $inBlog->publishDate, $inBlog->imageUrl, $inBlog->contentPath);
					if ($blogId > 0) {
						echo "Success! New id is $blogId";
					}
				}
			} break;
		
		}
	}
});

$app->run();

?>