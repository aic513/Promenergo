<?php

/*
 * Контроллер, который загружается по-умолчанию
 */

class Index_Controller extends Base
{

	protected $text;

	protected function input()  //берет данные на вход,наследует от класса Base
	{
		parent::input();
		$this->title .= 'Главная';
		$this->text = $this->ob_m->get_home_page();
		$this->keywords = $this->text['keywords'];
		$this->discription = $this->text['discription'];

	}

	protected function output()  //выдает данные на выход,наследует от класса Base
	{
		$this->content = $this->render(VIEW.'content',
			array('text' => $this->text));
		$this->page = parent::output();
		return $this->page;
	}
}