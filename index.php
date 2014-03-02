<?php

require_once 'php/setup.php';

$app = new \Slim\Slim();

$app->get('/', function() {
	$page = load_templated_page('index.html');

	echo $page;
});

$app->get('/blog/:blogSeoTitle(/)', function($blogSeoTitle) {
	$blog = load_blog_post($blogSeoTitle);
	if ($blog == null) {
		header('This is not the page you are looking for', true, 404);
		echo "Page not found.";
		exit();
	}

	$page = load_templated_page('blog_entry.html');
	
	if ($blog != null) {
		$page = templates\apply_model($blog, $page);
	}
	
	echo $page;
});

$app->get('/blog(/)', function () {
	$blogs = load_recent_blogs(10);

	$blog_html = '';
	foreach ($blogs as $blog) {
		$blogTitle = $blog->title;
		$blogSeoLink = $blog->seoTitle;
		$blogPublished = $blog->publishDate;

		$blog_html .= "<a href=\"/blog/$blogSeoLink\">$blogTitle</a> &mdash; $blogPublished<br/>";
	}

	echo str_replace('{{BLOGS}}', $blog_html, load_templated_page('blog.html'));
});

$app->get('/:page(/)', function($page) {
	if (strpos($page, '.html') == FALSE) {
		$page = "$page.html";
	}
	
	$html = load_templated_page($page);
	
	echo $html;
});

$app->post('/blog/:blogId/comments', function($blogId) {
	$body = http_get_request_body();
	if ($body == null) {
		echo json_encode(array("error" => "Bad HTTP Request body"));
		return;
	}

	$json = json_decode($body);

	$name = $json->name;
	$commentBody = $json->body;

	echo json_encode(array("data" => "Got comment from '$name' of '$commentBody' for blog with id $blogId" ));
});

$app->post('/blog', function() {
	$body = http_get_request_body();
	if ($body != null) {
		var_dump($body);
		$root = json_decode($body);
		var_dump($root);
		if ($root != null) {
			switch($root->type) {
			
				/* CREATE A BLOG */
				case BLOG: {
					$inBlog = $root->content;
					if ($inBlog != null) {
						$blogId = create_blog_post(
							$inBlog->title,
							$inBlog->author,
							$inBlog->publishDate,
							$inBlog->heroImageUrl,
							$inBlog->seoTitle,
							$inBlog->contentPath);

						if ($blogId > 0) {
							echo "Success! New id is $blogId";
						}
					}
				} break;
			
			}
		} else {
			echo json_last_error();
		}
	}
});

$app->run();

?>