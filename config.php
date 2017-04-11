<?php
/*
 * Файл с настройками сайта
 */

/*
 *Константы путей к папкам
 */
defined('PROM') or exit('Access denied');  //проверяем на существование константу PROM,чтобы никто не имел доступа к файлам

define('CONTROLLER', 'core/controller');  //путь к контроллеру

define('MODEL', 'core/model');  //путь к модели

define('VIEW', '/template/default/');  //путь к шаблону

define('LIB','lib');  //путь к библиотекам

define('SITE_URL', 'promenergo.loc/');  //базовый путь к сайту

define('QUANTITY', 5);  //количество выводимых товаров при постраничной навигации

define('QUANTITY_LINKS', 3);  //ссылки при постраничной навигации

define('UPLOAD_DIR', 'images/');  //путь к папке с картинками товаров

/*
 * Константы подключения к БД
 */
define('HOST', 'localhost');

define('USER', 'root');

define('PASSWORD', '');

define('DB_NAME', 'promenergo');

define('IMG_WIDTH',116);

$conf = array(   //массив с настройками для подключения скриптов и стилей в header
    'styles' => array(  //пользовательская часть
        'style.css'
    ),
    'scripts' => array(
        'JS/jquery-1.7.2.min.js',
        'JS/jquery-ui-1.8.20.custom.min.js',
        'JS/jquery.cookie.js',
        'JS/js.js',
        'JS/script.js',
    ),
    'styles_admin' => array(  //админская часть
        'style.css'
    ),
    'scripts_admin' => array(
        'JS/tiny_mce/tiny_mce.js',
        'JS/tiny_script.js',
    ),
); 