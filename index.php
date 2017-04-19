<?php

define('PROM', TRUE);  //закрываем доступ к папкам с помощью этой константы

header("Content-Type:text/html;charset=utf-8");

error_reporting(0);

session_start();

require "config.php";

/*
 * подключаем файлы и библиотеки
 */

set_include_path(get_include_path()  //задаем пути для покдлючения файлов,php сам будет перебирать пути,пока не найдет нужный
	.PATH_SEPARATOR.CONTROLLER
	.PATH_SEPARATOR.MODEL
	.PATH_SEPARATOR.LIB
);

function __autoload($class_name)  //автозагрузка классов
{

	if (strpos($class_name, "PHPExcel") === 0)  //для создания объекта класса PHPExcel
	{
		return;
	}

	if (!include_once($class_name.".php")) {

		try {
			throw new ContrException($class_name.'Не правильный файл для подключения');
		} catch (ContrException $e) {
			echo $e->getMessage();
		}
	}
}

try {
	$obj = Route_Controller::get_instance();
	$obj->route();
} catch (ContrException $e) {
	return;
}

