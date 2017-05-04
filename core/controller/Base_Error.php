<?php
defined('PROM') or exit('Access denied');
/*
 * Абстрактный класс для вывода ошибок-исключений на сайте
 */

abstract class Base_Error extends Base_Controller
{

	protected $message_err;
	protected $title;

	protected function input()
	{
		$this->title = 'Страница показа ошибок';
	}

	protected function output()
	{

		$page = $this->render(VIEW.'error_page', array(  //генерируем шаблон для вывода ошибок на экран
				'title' => $this->title,
				'error' => $this->message_err
			)
		);
		return $page;
	}
}

?>