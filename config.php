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

define('LIB', 'lib');  //путь к библиотекам

define('SITE_URL', '/');  //базовый путь к сайту !!!ОЛЕНЬ!!!!

define('QUANTITY', 3);  //количество выводимых товаров при постраничной навигации

define('QUANTITY_LINKS', 3);  //ссылки при постраничной навигации

define('UPLOAD_DIR', 'images/');  //путь к папке с картинками товаров

/*
 * Константы подключения к БД
 */
define('HOST', 'localhost');

define('USER', 'root');

define('PASSWORD', '');

define('DB_NAME', 'promenergo');

define('IMG_WIDTH', 116);

/*
 * Константы, относящиеся к безопаснсти сайта
 */
define('FEALT',1);  //количество дней, на которое будет забанен пользователь

define('VERSION','111');  //версия создаваемого файла cookie

define('KEY','GTHSMKGG5335bbbFFF55rfghubjj355335');  //ключ шифрования

define('EXPIRATION',600);   //время, по истечению которого пользователю необходимо переавторизоваться (если от юзера нет никакой активности в админке)

define('WARNING_TIME',300);  //время, после которого файлы куки будут обновляться (для юзеров, которые работают в админке), время предупреждения

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
		'JS/tinymce/tinymce.min.js',
		'JS/tiny_script.js',
	),
);


