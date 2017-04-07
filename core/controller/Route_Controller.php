<?php

/*
 * класс,котрый парсит адресную строку как контроллер/передаваемые параметры
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

    private function __construct()
    {
        $address = $_SERVER['REQUEST_URI'];
        $path = $_SERVER['SERVER_NAME'] . '/';
        if ($path === SITE_URL) {
            $this->request_url = trim($address, '/');
            $url = explode('/', $this->request_url);
            if (!empty($url[0])) {  //сохраняем контроллер в свойство $controller
                $this->controller = ucfirst($url[0]) . '_Controller'; //делаем первую букву заглавной в нулевом элементе массива из url-адреса
            } else {
                $this->controller = "Index_Controller";
            }
            /*
             * Сохраняем параметры из адресной строки в свойство $params
             */
            $count = count($url);
            if (!empty($url[1])) {
                $key = array();
                $value = array();
                for ($i = 1; $i < $count; $i++) {
                    if ($i%2!= 0) {
                        $key[] = $url[$i];
                    } else {
                        $value[] = $url[$i];
                    }
                }
                $this->params = array_combine($key,$value);
                print_r($this->params);
//                if (!$this->params = array_combine($key, $value)) {
                   // throw new ContrException("Не правильный адресс", $address);
//                }
            }

        } else {
            try {
                throw new Exception ('Неправильный адрес сайта');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }

}