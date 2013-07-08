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

		if ($body == 'news')
		{
			$this->bodyFile = 'main_news.tpl';
		}
		elseif ($body == 'search')
		{
			$this->bodyFile = 'main_search.tpl';
		}
		elseif ($body == 'error')
		{
			$this->bodyFile = 'error.tpl';
		}
		else
		{
			$this->bodyFile = 'main.tpl';
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
		switch ($page)
		{
			case PAGE_STATS:
				$layout = new self($page, 'dynamic', 'main', 'stats');
				$vars['title'] = 'Статус серверов';
				$vars['mainBlock'] = true;
				$vars['newsLoader'] = false;
				break;

			case PAGE_NEWS:
			case PAGE_NEWS_PART:
				$layout = new self($page, 'dynamic', 'main');
				$vars['title'] = 'Новости проекта';
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = true;
				break;

			case PAGE_NEWS_SEARCH:
				$layout = new self($page, 'dynamic', 'search');
				$vars['title'] = 'Поиск новостей';
				$vars['mainBlock'] = false;
				$vars['newsLoader'] = false;
				break;

			case PAGE_NEWS_ENTRY:
				$layout = new self($page, 'dynamic', 'news');
				break;

			case PAGE_RULES:
				$layout = new self($page, 'dynamic', 'main', 'static/rules');
				$vars['title'] = 'Правила сервера';
				$vars['mainBlock'] = true;
				$vars['newsLoader'] = false;
				break;

			case PAGE_ERROR_404:
				$layout = new self($page, 'static', 'error');
				$vars['errorTitle'] = '404 - Страница не найдена';
				$vars['errorClass'] = 'error404';
				break;

			case PAGE_MAIN:
			default:
				$content = 'static/main';
				if ($config['website']['main_block'])
				{
					//@todo: WTF?
					if (rand(0,1) || $config['website']['main_block'] == 2)
					{
						$sliderContent = self::loadSliderContent();
						if ($sliderContent)
						{
							$content = 'slider';
							$vars['sliderContent'] = $sliderContent;
						}
					}
				}

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
		global $skins;
		global $config;
		global $user;
		global $app_version;

		$layout->assign('site', $config['website']);
		$layout->assign('app_version', $app_version);
		$layout->assign('forumSkin', $skins[$user->getSkin()]);
		$layout->assign('user', $user);
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
