<?php

require_once dirname(__FILE__) . '/includes/smarty.php';

class LayoutManager extends Smarty_Studio
{
	protected $headerFile;
	protected $bodyFile;
	protected $bodyContent;
	protected $pageID;

    public function __construct($page_ID, $header, $body, $body_content = '')
	{
		global $config;

		parent::__construct($config['website']['template']);

		if ($header == 'dynamic')
		{
			$this->headerFile = 'header_dynamic.tpl';
		}
		else
		{
			$this->headerFile = 'header.tpl';
		}

		switch ($body)
		{
			case 'news':
				$this->bodyFile = 'main_news.tpl';
				break;

			case 'search':
				$this->bodyFile = 'catalog.tpl';
				break;

			case 'error':
				$this->bodyFile = 'error.tpl';
				break;

			case 'about':
				$this->bodyFile = 'about.tpl';
				break;
			
			case 'catalog':
				$this->bodyFile = 'catalog.tpl';
				break;
				
			case 'catalog_item':
				$this->bodyFile = 'catalog_item.tpl';
				break;

			case 'main':
			default:
				$this->bodyFile = 'main.tpl';
				break;
		}

		if ($body_content)
		{
			$this->bodyContent = $body_content;
		}

		$this->pageID = $page_ID;
	}

	public static function buildPage($page = PAGE_MAIN, $vars = array())
	{
		global $config;
		global $lang;
		switch ($page)
		{
			case PAGE_NEWS:
			case PAGE_NEWS_PART:
				$layout = new self($page, 'dynamic', 'main');
				$vars['title'] = $lang['title_news'];
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = true;
				break;

			case PAGE_NEWS_ENTRY:
				$layout = new self($page, 'dynamic', 'news');
				break;

			case PAGE_ABOUT:
				$layout = new self($page, 'dynamic', 'about');
				$vars['title'] = $lang['title_about'];
				break;

			case PAGE_ERROR_404:
				$layout = new self($page, 'dynamic', 'error');
				$vars['title'] = $vars['error']['title'] = $lang['404_title'];
				$vars['error']['description'] = $lang['404_description'];
				$vars['error']['class'] = 'error404';
				$vars['error']['referer'] = $_SERVER['HTTP_REFERER'];
				break;

			case PAGE_CATALOG:
			case PAGE_CATALOG_PART:
				$layout = new self($page, 'dynamic', 'catalog');
				$vars['title'] = $lang['title_catalog'];
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = false;
				break;

			case PAGE_CATALOG_SEARCH:
				$layout = new self($page, 'dynamic', 'search');
				$vars['title'] = $lang['title_cat_search'];
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = false;
				break;

			case PAGE_CATALOG_ITEM:
				$layout = new self($page, 'dynamic', 'catalog_item');
				$vars['title'] = $lang['title_catalog'];
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = false;
				break;

			case PAGE_MAIN:
			default:
				$content = 'static/main';

				$layout = new self($page, 'static', 'main', $content);

				$vars['mainBlock'] = true;
				$vars['newsLoader'] = true;
				break;
		}

		foreach ($vars as $key => $var)
		{
			$layout->assign($key, $var);
		}

		return $layout;
	}

	public static function render($layout)
	{
		global $config;
		global $lang;
		global $app_version;

		$layout->assign('lang', $lang);
		$layout->assign('locale', $config['website']['locale']);
		$layout->assign('site', $config['website']);
		$layout->assign('app_version', $app_version);
		$layout->assign('debug', $config['debug']);

		$layout->assign('header', $layout->getHeader());
		$layout->assign('bodyContent', $layout->getBodyContent());
		$layout->assign('pageName', $layout->getPageID());

		$layout->assign('contentDir', $config['website']['content_dir']);

		return $layout->fetch($layout->getBody());
	}

	public static function loadSliderContent()
	{
		global $config;
		global $DB;

		if (!$config['website']['main_block'])
			return false;

		$content = $DB->select('SELECT id, contentImage, description, link FROM ?_slider_content ORDER BY id DESC LIMIT 5');
		return $content;
	}

	public function getHeader()
	{
		return $this->headerFile;
	}

	public function getBody()
	{
		return $this->bodyFile;
	}

	public function getBodyContent()
	{
		return $this->bodyContent;
	}

	public function getPageID()
	{
		return $this->pageID;
	}
}
