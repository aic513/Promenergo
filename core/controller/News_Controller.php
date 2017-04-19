<?php

/*
 * Класс, отвечающий за вывод полного списка новостей
 */

class News_Controller extends Base
{

	protected $news_text;  //свойство текста новости в полном размере

	protected function input($params)
	{
		parent::input();

		$this->title .= "Новости";  //формируем заголовок для страницы

		if (isset($params['id'])) {  //очищаем данные от лишних символов
			$id = $this->clear_int($params['id']);
		}
		if ($id) {
			$this->news_text = $this->ob_m->get_news_text($id);  //передаем id  в метод вывода новостей в объект модели
			$this->keywords = $this->news_text['keywords'];
			$this->discription = $this->news_text['discription'];
		}
	}

	protected function output()
	{

		$this->content = $this->render(VIEW.'news_page', array(
			'news_text' => $this->news_text
		));

		$this->page = parent::output();
		return $this->page;
	}
}