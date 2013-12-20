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
	'records'			=>	'запись;записи;записей',
	'found'				=>	'найден;найдено;найдено',
	'hours'				=>	'ч.',
	'minutes'			=>	'мин.',
	'close'				=>	'Закрыть',
	
	// titles
	'title_about'		=>	'О проекте',
	'title_about_ext'	=>	'О нашем проекте',
	'title_catalog'		=>	'Каталог',
	'title_cat_search'	=>	'Поиск предметов',
	'title_catalog_add'	=>	'Добавление предмета',

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
	'full_news_entry'	=>	'Читать далее &raquo;',

	// catalog
	'catalog_welcome'	=>	'Добро пожаловать в наш супер-пупер мега каталог.',
	'move_to_catalog'	=> 	'Перейти к каталогу &raquo;',
	'detailed_info'		=> 	'Подробная информация',
	'show_detailed_info'=> 	'Подробнее &raquo;',
	'details'			=> 	'Подробнее',
	'on_your_request'	=>	'По вашему запросу',
	'there_are_items'	=>	'В нашей базе данных уже',
	'item_decl'			=>	' предмет; предмета; предметов',
	'show_filter'		=>	'Показать фильтр',
	'filter'			=>	'Отфильтровать',
	'clear'				=>	'Очистить фильтр',
	'add_item'			=>	'Добавить предмет в каталог',
	'item_add_success'	=>	'Новый предмет успешно добавлен',
	'item_add_fail'		=>	'При добавлении предмета в каталог возникла ошибка',
	
	// item data
	'item_id'			=>	'Идентификатор',
	'image'				=>	'Изображение',
	'image_URL'			=>	'Ссылка на фото',
	'thumbnail_URL'		=>	'Ссылка на миниатюру',
	'no_image'			=>	'Нет изображения',
	'category'			=>	'Категория',
	'material'			=>	'Материал',
	'region'			=>	'Область',
	'district'			=>	'Район',
	'town'				=>	'Населенный пункт',
	'digging'			=>	'Раскоп',
	'square'			=>	'Квадрат',
	'layer'				=>	'Слой',
	'field_number'		=>	'Полевой номер',
	'area'				=>	'Участок',
	'homestead'			=>	'Усадьба',
	'gps_coordinates'	=>	'GPS координаты',
	'year'				=>	'Год',
	'dating'			=>	'Датировка',
	'storage'			=>	'Место хранения',
	'title'				=>	'Наименование',
	'description'		=>	'Описание',
	'notes'				=>	'Примечания',

	// footer
	'all_rights_reserved'=>'Все права защищены.',
);

?>