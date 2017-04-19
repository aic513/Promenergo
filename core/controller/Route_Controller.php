<?php

/*
 * класс,котрый парсит адресную строку в виде контроллер/передаваемые параметры
 * используем шаблон Singleton
 */

class Route_Controller extends Base_Controller
{
	static $instance;

	static function get_instance()
	{
		if (self::$instance instanceof self) {
			return self::$instance;
		} else {
			return self::$instance = new self;
		}
	}

	private function __construct()    //при загрузке класса мы разбираем адресную строку,и если есть,то выделяем параметры,переданные в нее
	{
		$address = $_SERVER['REQUEST_URI'];
		$path = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));

		if ($path === SITE_URL) {
			$this->request_url = substr($address, strlen(SITE_URL));

			$url = explode('/', rtrim($this->request_url, '/'));

			if (!empty($url[0])) {
				$this->controller = ucfirst($url[0]).'_Controller'; //делаем первую букву заглавной в нулевом элементе массива из url-адреса
			} else {
				$this->controller = "Index_Controller";
			}
			$count = count($url);
			/*
			  * Сохраняем параметры из адресной строки в свойство $params
			*/
			if (!empty($url[1])) {

				$key = array();
				$value = array();

				for ($i = 1; $i < $count; $i++) {

					if ($i % 2 != 0) {
						$key[] = $url[$i];
					} else {
						$value[] = $url[$i];
					}
				}

				if (!$this->params = array_combine($key, $value)) {
					throw new ContrException("Не правильный адресс", $address);
				}
			}
		} else {
			try {
				throw new Exception('<p style="color:red">Не правильный адрес сайта.</p>');
			} catch (Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
	}

}