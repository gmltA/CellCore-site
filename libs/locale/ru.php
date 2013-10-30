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
	'title_catalog'		=>	'Каталог',
	'title_cat_search'	=>	'Поиск предметов',

	// error
	'404_title'			=>	'404 - Страница не найдена',
	'404_description'	=>	'Страница не найдена. Либо она была удалена, либо никогда не существовала.',

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

	// footer
	'trademark_info'	=>	'Все товарные знаки являются собственностью соответствующих владельцев.',
	'all_rights_reserved'=>'Все права защищены.',
);

?>