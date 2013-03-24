<?php
if (!defined('IS_IN_ENGINE'))
{
    header("HTTP/1.1 403 Forbidden");
    die('<h1>403 Forbidden</h1>');
}

// Директория
global $cwd;
global $config;

$cwd = str_replace("\\", "/", getcwd());

// загружаем библиотеку Smarty
require_once dirname(__FILE__) . '/smarty/Smarty.class.php';

class Smarty_Studio extends Smarty
{
    function __construct() {
        parent::__construct();

        global $cwd;
        global $config;
        global $settings;

        // Папки с шаблонами, кэшом шаблонов и настройками
        $this->setTemplateDir($cwd.'/templates/'.$config['website']['template'].'/');
        $this->setCompileDir($cwd.'/cache/templates/'.$config['website']['template'].'/');
        $this->setConfigDir($cwd.'/libs/');
        $this->setCacheDir($cwd.'/cache/pages/');
        $this->assign('MainTemplateDir', 'templates/'.$config['website']['template']);

        // Время кеширования страниц
        $this->cache_lifetime = 3*60;

        // Общее кеширование
        $this->caching = false;

        function smarty_block_nocache($param, $content, &$smarty)
        {
            return $content;
        }

        // Режим отладки
        $this->debugging = $config['debug'];
        // Разделители
        $this->left_delimiter = '{';
        $this->right_delimiter = '}';

        if (!$this->debugging)
        {
            $this->loadFilter('output', 'singlestring');
        }
    }

    function uDebug($name, $val = 'unset')
    {
        $this->append($name,$val);
    }
}
