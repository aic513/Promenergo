<?php
defined('PROM') or exit('Access denied');
/*
 * Контроллер для преобразования URL-адресов
 * Контроллер, без которого вообще не будет работать сайт
 * Основное логическое ядро сайта
 * Все контроллеры являются его наследниками
 */

abstract class Base_Controller
{
	protected $request_url;  //url-запрос для конкретного контроллера
	protected $controller;  //имя контроллера,который запрашивает пользователь
	protected $params;  //параметры,передаваемые в url
	protected $styles, $styles_admin;
	protected $scripts, $scripts_admin;
	protected $error;  //свойство хранения ошибок на сайте, если они возникают
	protected $page;  //здесь будет храниться страница,возвращенная методом output
	
	public function route()  //загружает определенный контроллер
	{
		if (class_exists($this->controller))  //есть ли у этого класса,который передан в адресной строке такой контроллер?
		{

			$ref = new ReflectionClass($this->controller);  //передали конструктуру имя класса

			if ($ref->hasMethod('request'))  //есть ли метод request?
			{

				if ($ref->isInstantiable()) {  //можно ли получить объект этого класса?
					$class = $ref->newInstance();  //получаем объект этого класса в $class
					$method = $ref->getMethod('request');  //запускаем у этого объекта метод request
					$method->invoke($class, $this->get_params());  //передаем методу request параметры
				}
			}

		} else {
			throw new ContrException('Такой страницы не существует', 'Контроллер - '.$this->controller);
		}

	}
	
	public function init()  //формирует массив стилей и скриптов
	{
		global $conf;
		if (isset($conf['styles'])) {
			foreach ($conf['styles'] as $style) {
				$this->styles[] = trim($style, '/');
			}
		}
		
		if (isset($conf['styles_admin'])) {
			foreach ($conf['styles_admin'] as $style_admin) {
				$this->styles_admin[] = trim($style_admin, '/');
			}
		}
		
		if (isset($conf['scripts'])) {
			foreach ($conf['scripts'] as $script) {
				$this->scripts[] = trim($script, '/');
			}
		}
		
		if (isset($conf['scripts_admin'])) {
			foreach ($conf['scripts_admin'] as $script_admin) {
				$this->scripts_admin[] = trim($script_admin, '/');
			}
		}
	}
	
	protected function get_controller()  //возвращает контроллер
	{
		return $this->controller;
	}
	
	protected function get_params()  //возвращает массив параметров
	{
		return $this->params;
	}
	
	protected function input()  //берет данные на вход
	{
	}
	
	protected function output()  //выдает данные на выход
	{
	}
	
	public function write_error($err)  //выводит ошибки
	{
		$time = date('l jS \of F Y h:i:s A');
		$str = "Fault: ".$time." - ".$err."\n\r";
		file_put_contents("log.txt", $str, FILE_APPEND);
	}

	public function get_page()  //вывод страницы на экран
	{
		echo $this->page;
	}
	

	public function request($param = array())  //метод запусает метод route
	{
		$this->init();  //загружаем стили и скрипты
		$this->input($param);  //формируем начальные данные
		$this->output();  //генерируем шаблон из кусков данных

		if (!empty($this->error)) {  //есть ли ошибки?
			$this->write_error($this->error);
		}

		$this->get_page();  //выводим страницу на экран
	}
	
	public function render($path, $param = array())  //метод-шаблонизатор,в этот метод передаем переменные,которые потом выводим в шаблоне
	{
		extract($param);  //создаем в памяти переменные,которые передали массивом
		ob_start();  //открываем буфер обмена
		if (!include($path.'.php')) {
			throw new ContrException('Данного шаблона не существует');
		}
		return ob_get_clean();  //возвращаем данные из буфера и очищаем его
	}
	
	public function clear_str($var)  //очистка строковых данных
	{
		if (is_array($var)) {
			$row = array();
			foreach ($var as $key => $item) {
				$row[$key] = trim(strip_tags($item));
			}
			return $row;
		}
		return trim(strip_tags($var));
	}
	
	public function clear_int($var)  //очистка числовых данных
	{
		return (int)$var;
	}
	
	public function is_post()  //проверка,что данные пришли методом POST
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function check_auth()  //проверка авторизации
	{
		try {  //методы, которые проверяют, действительно ли пользователь авторизован на сайте?
			$cookie = Model_User::get_instance();  //создаю объект класса Model_User
			$cookie->check_id_user();
			$cookie->validate_cookie();
			//exit();
		} catch (AuthException $e) {  //здесь вылетит исключение, если произошла ошибка в методах выше
			$this->error = "Ошибка авторизации пользователя | ";
			$this->error .= $e->getMessage();
			$this->write_error($this->error);
			header("Location:".SITE_URL."login");
			exit();
		}
	}
	
	public function img_resize($dest, $type)  //уменьшает картинку
	{
		switch ($type) {
			case 'jpeg':
				$img_id = imageCreateFromJpeg($dest);  //хранит ресурс исходного изображения
				break;
		}

//		$img_id = imageCreateFromJpeg($dest);

		$img_width = imageSX($img_id);  //ширина картинки
		$img_height = imageSY($img_id);  //высота картинки

		$k = round($img_width / IMG_WIDTH, 2);  //коэффициент пропорциональности

		$img_mini_width = round($img_width / $k);  //min ширина
		$img_mini_height = round($img_height / $k);  //min высота

		$img_dest_id = imageCreateTrueColor($img_mini_width, $img_mini_height);  //создаем новое пустое изображение

		$result = imageCopyResampled(  //создаем уменьшенную копию картинки
			$img_dest_id,  //ресурс изображения
			$img_id,  //ресурс изображения, из которого делаем копию
			/*
			 *координаты
			 */
			0,
			0,
			0,
			0,
			/*
			 * размеры создаваемого изображения
			 */
			$img_mini_width,
			$img_mini_height,
			/*
			 * размеры исходного изображения
			 */
			$img_width,
			$img_height
		);
		$name_img = $this->rand_str().'.jpg';  //имя изображения

		$img = imageJpeg($img_dest_id, UPLOAD_DIR.$name_img, 100);  //создаем файл изображения и сохраняем его

		/*
		 * очищаем память
		 */
		
		imageDestroy($img_id);  //удаляем ресурс исходного изображения
		imageDestroy($img_dest_id);  //удаляем ресурс созданного изображения

		if ($img) {
			return $name_img;
		} else {
			return FALSE;
		}
	}

	protected function rand_str()  //формирует случайное имя для изображения
	{
		$str = md5(microtime());

		return substr($str, 0, 10);
	}

}