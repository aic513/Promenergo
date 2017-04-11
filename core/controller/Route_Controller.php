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
        $path = $_SERVER['SERVER_NAME'] . '/';
        if ($path === SITE_URL) {
            $this->request_url = rtrim($address, '/');
            $url = explode('/', $this->request_url);
            print_r($url);
            if (!empty($url[0])) {  //сохраняем контроллер в свойство $controller
                $this->controller = ucfirst($url[0]) . '_Controller'; //делаем первую букву заглавной в нулевом элементе массива из url-адреса

            } else {
                $this->controller = "Index_Controller";
            }
            print_r($this->controller);
            /*
             * Сохраняем параметры из адресной строки в свойство $params
             */
            $count = count($url[1]);

            if(!empty($url[1])) {

                $key = array();
                $value = array();

                for($i = 1;$i < $count; $i++) {

                    if($i%2 != 0) {
                        $key[] = $url[$i];
                    }
                    else {
                        $value[] = $url[$i];
                    }
                }

                if(!$this->params = array_combine($key,$value)) {
                   // throw new ContrException("Не правильный адресс",$address);
                }
            }
        }
        else {
            try{
                throw new Exception('<p style="color:red">Не правильный адресс сайта.</p>');
            }
            catch(Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }

}