<?php

/*
 * Контроллер для преобразования URL-адресов
 */

abstract class Base_Controller
{
    protected $request_url;  //url-запрос для конкретного контроллера
    protected $controller;  //имя контроллера,который запрашивает пользователь
    protected $params;  //параметры,передаваемые в url
    protected $styles, $styles_admin;
    protected $scripts, $scripts_admin;
    protected $error;
    protected $page;  //здесь будет храниться страница,возвразенная методом output

    public function route()  //загружает определнный контроллер
    {

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
        $time = date("d-m-Y G:I:s");
        $str = "Fault" . $time . " - " . $err . "\n\r";
        file_put_contents("log.txt", $str, FILE_APPEND);
    }

    public function get_page()  //вывод страницы на экран
    {
        echo $this->page;
    }

    public function request($param = array())   //метод запусает метод route
    {
        $this->init();
        $this->input($param);
        $this->output();
        if (!empty($this->error)) {
            $this->write_error();
        }
    }

    public function render($path, $param = array())  //метод-шаблонизатор
    {
        extract($param);  //создаем в памяти переменные,которые передали массивом
        ob_start();  //открываем буфер обмена
        if (!include($path . 'php')) {
            throw new ContrExeption('Данного шаблона не существует');
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

    public function is_post()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_auth()  //проверка авторизации
    {

    }

    public function img_resize($dest)  //уменьшает картинку
    {

    }


}