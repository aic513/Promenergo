<?php

/*
 *Описательный класс для админки
 */

abstract class Base_Admin extends Base_Controller
{

	protected $ob_m;  //объект модели сайта

	protected $ob_us;  //объект модели работы с юзером

	protected $title;  //заголовок страниц

	protected $style;

	protected $script;

	protected $content;  //шаблон центральной части

	protected $user = TRUE;  //нужно ли авторизироваться пользоветелю на сайте,или нет?


	protected function input()
	{

		if ($this->user == TRUE) {  //авторизировался ли пользователь на сайте?
			$this->check_auth();
		}

		$this->title = "ПромЭнергоСтрой |";

		foreach ($this->styles_admin as $style) {
			$this->style[] = SITE_URL.VIEW.'admin/'.$style;
		}

		foreach ($this->scripts_admin as $script) {
			$this->script[] = SITE_URL.VIEW.'admin/'.$script;
		}

		$this->ob_m = Model::get_instance();  //обращаемся к модели
		$this->ob_us = Model_User::get_instance();  //обращаемся к модели юзера

	}


	protected function output()
	{

		$header = $this->render(VIEW.'admin/header', array(
			'title' => $this->title,
			'styles' => $this->style,
			'scripts' => $this->script
		));
		$left_bar = $this->render(VIEW.'admin/left_bar');

		$footer = $this->render(VIEW.'admin/footer');

		$page = $this->render(VIEW.'admin/index', array(
			'header' => $header,
			'left_bar' => $left_bar,
			'content' => $this->content,
			'footer' => $footer
		));
		return $page;
	}
}

?>