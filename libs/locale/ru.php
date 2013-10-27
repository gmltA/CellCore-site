<?php
if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

global $lang;

$lang = array(
    'id'				=>	'ru',

	// general
	'main_page'			=>	'Главная',
	'news_page'			=>	'Новости',
	'auth'				=>	'Авторизация',
	'register'			=>	'Регистрация',
	'anonymous'			=>	'Anonymous',
	'search'			=>	'Поиск',
	'search_result_1'	=>	'По запросу',
	'search_result_2'	=>	'найдено',
	'records'			=>	'запись;записи;записей',
	'hours'				=>	'ч.',
	'minutes'			=>	'мин.',
	
	// titles
	'title_stats'		=>	'Статус серверов',
	'title_news'		=>	'Новости проекта',
	'title_search'		=>	'Поиск новостей',
	'title_rules'		=>	'Правила сервера',
	'title_core'		=>	'О ядре',
	'title_about'		=>	'Обновление сайта',
	'title_catalog'		=>	'Каталог',
	'title_cat_search'	=>	'Поиск предметов',
	
	// error
	'404_title'			=>	'404 - Страница не найдена',
	'404_description'	=>	'Страница не найдена. Либо она была удалена, либо никогда не существовала.',

	// header
	'to_site'			=>	'Перейти на сайт',
	'to_forum'			=>	'Перейти к списку форумов',
	'to_users'			=>	'Перейти к списку пользователей',
	'to_tracker'		=>	'Перейти к BugTracker\'у',
	'to_gallery'		=>	'Перейти к галереи',
	'to_blogs'			=>	'Перейти к блогам',
	'to_awards'			=>	'Перейти к списку наград',
	'to_db'				=>	'Перейти к базе знаний',
	
	'forum'				=>	'Форумы',
	'users'				=>	'Пользователи',
	'tracker'			=>	'Ошибки',
	'gallery'			=>	'Галерея',
	'blogs'				=>	'Блоги',
	'awards'			=>	'Награды',
	'db'				=>	'База знаний WoW',

	// navigation
	'other_news'		=>	'Остальные новости',
	'nav_up'			=>	'Наверх',
	'nav_back'			=>	'Назад',

	// news
	'views'				=>	'Просмотров',
	'comments'			=>	'Комментарии',
	'tags'				=>	'Метки',
	'full_news'			=>	'Новость целиком',

	// comments
	'new_comment'		=>	'Новый комментарий',
	'post_comment'		=>	'Оставить комментарий',
	'posting_comment'	=>	'Отправка комментария',
	'preview_comment'	=>	'Предпросмотр',
	'edit_comment'		=>	'Редактирование',

	// stats
	'full_online'		=>	'Всего онлайн',
	'alliance_online'	=>	'Альянс онлайн',
	'horde_online'		=>	'Орда онлайн',
	'max_uptime'		=>	'Максимальное время работы',
	'current_uptime'	=>	'Текущее время работы',

	// footer
	'trademark_info'	=>	'Все товарные знаки являются собственностью соответствующих владельцев.',
	'all_rights_reserved'=>'Все права защищены.',
);

?>