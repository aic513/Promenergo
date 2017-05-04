<?php
defined('PROM') or exit('Access denied');
/*
 * Класс, который выводит страницу карты сайта
 */

class Map_Controller extends Base
{
	protected function input()
	{
		parent::input();
		$this->title .= "Карта сайта";

		$this->pages = $this->ob_m->get_pages();  //получаем массив страниц

		$this->catalog = $this->ob_m->get_catalog_brands();  //получаем массив категорий

		$this->keywords = "Карта сайта";
		$this->discription = "Промстрой энерго карта сайта";

	}

	protected function output()
	{
		$this->content = $this->render(VIEW . 'sitemap_page',
			array(
				'pages' => $this->pages,
				'catalog' => $this->catalog
			)
		);

		$this->page = parent::output();

		return $this->page;
	}
}