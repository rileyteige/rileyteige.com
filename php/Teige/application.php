<?php

namespace Teige;

require_once '/php/lib/redbean/rb.php';

require_once 'blogProvider.php';
require_once 'globals.php';
require_once 'sqlcreds.php';
require_once 'resourceManager.php';
require_once 'router.php';
require_once 'templateManager.php';

require_once 'Data/blogRepository.php';
require_once 'Util/httpHelper.php';
require_once 'Util/pageTemplateHelper.php';

use Teige\Data;
use Teige\Util;

$currentApplication = null;

/*
 * Defines the site application.
 */
class Application
{
	function __construct() {
		global $currentApplication;

		if ($currentApplication != null) {
			throw new Exception("Application can only be initialized once.");
		}

		$currentApplication = $this;
	}

	/*
	 * Returns the current application.
	 */
	public static function current() {
		global $currentApplication;
		return $currentApplication;
	}

	/*
	 * Starting point for the application.
	 */
	public function start() {
		$this->resourceManager = new ResourceManager();
		$this->templateManager = new TemplateManager();

		$this->templateManager->registerHelperMethods();
		$this->resourceManager->register();

		$router = $this->buildRouteHandlers(new Router());

		$this->initializeExternalLibraries();

		if ($router != null) {
			$router->processRoute();
		}
	}

	/*
	 * Builds route handlers into a site router.
	 */
	private function buildRouteHandlers($router) {
		$router->get('/', function() {
			$page = Util\PageTemplateHelper::loadPageTemplate('index.html');

			echo $page;
		});

		$router->get('/blog/:blogSeoTitle(/)', function($blogSeoTitle) {
			$blogProvider = new BlogProvider(new Data\BlogRepository());
			$blog = $blogProvider->loadBlogPost($blogSeoTitle);
			if ($blog == null) {
				header('This is not the page you are looking for', true, 404);
				echo "Page not found.";
				exit();
			}

			$page = Util\PageTemplateHelper::loadPageTemplate('blog_entry.html');
			
			if ($blog != null) {
				$page = Util\PageTemplateHelper::applyModel($blog, $page);
			}
			
			echo $page;
		});

		$router->get('/blog(/)', function () {
			$blogProvider = new BlogProvider(new Data\BlogRepository());
			$blogs = $blogProvider->loadRecentBlogs(10);

			$blog_html = '';
			foreach ($blogs as $blog) {
				$blogTitle = $blog->title;
				$blogSeoLink = $blog->seoTitle;
				$blogPublished = $blog->publishDate;

				$blog_html .= "<a href=\"/blog/$blogSeoLink\">$blogTitle</a> &mdash; $blogPublished<br/>";
			}

			echo str_replace('{{BLOGS}}', $blog_html, Util\PageTemplateHelper::loadPageTemplate('blog.html'));
		});

		$router->get('/:page(/)', function($page) {
			if (strpos($page, '.html') == FALSE) {
				$page = "$page.html";
			}
			
			$html = load_templated_page($page);
			
			echo $html;
		});

		$router->post('/blog/:blogId/comments', function($blogId) {
			$body = Util\HttpHelper::getRequestBody();
			if ($body == null) {
				echo json_encode(array("error" => "Bad HTTP Request body"));
				return;
			}

			$json = json_decode($body);

			$name = $json->name;
			$commentBody = $json->body;

			echo json_encode(array("data" => "Got comment from '$name' of '$commentBody' for blog with id $blogId" ));
		});

		$router->post('/blog', function() {
			$body = Util\HttpHelper::getRequestBody();
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
								$blogProvider = new BlogProvider(new Data\BlogRepository());
								$blogId = $blogProvider->createBlogPost(
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

		return $router;
	}

	/*
	 * Initializes any external libraries that might need
	 * to be initialized.
	 */
	private function initializeExternalLibraries() {
		$credentials = new DatabaseCredentials();
		\R::setup('sqlite:'.$credentials->databaseName(), 
					$credentials->username(), 
					$credentials->password());
	}
}

?>