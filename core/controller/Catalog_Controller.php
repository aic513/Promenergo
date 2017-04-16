<?php

/*
 * Контроллер каталога товаров
 */

class Catalog_Controller extends Base
{
	
	/* Сначала проверяем, чтобы загружался контент кроме центральной части,ее загрежаем отдельно

	 * protected function input()  //берет данные на вход
	{
		parent::input();
	}

	protected function output()  //выдает данные на выход
	{
		$this->page = parent::output();
		return $this->page;
	}*/
	
	protected $type = FALSE;
	protected $id = FALSE;
	protected $parent = FALSE;
	protected $navigation;  //массив ссылок для постраничной навигации
	protected $catalog; //массив товаров для вывода на экран
	protected $krohi;  //массив хлебных крошек
	
	protected function input($param = array())  //$param - массив параметров, который приходит к нам в контроллер
	{
		
		parent::input();
		
		$this->title .= "Каталог";  //пристыковываем имя
		
		$this->right_side = FALSE;  //убираем правый блок
		
		if (isset($param['brand'])) {  //если существует brand
			$this->type = "brand";
			$this->id = $this->clear_int($param['brand']);

		} elseif (isset($param['type'])) {  //если существует type
			$this->type = "type";
			$this->id = $this->clear_int($param['type']);

		} elseif (isset($param['parent'])) {  //или родительская категория
			$this->parent = TRUE;
			$this->id = $this->clear_int($param['parent']);
		}
		
		if (isset($param['page'])) {  //была ли передана страница?
			$page = $this->clear_int($param['page']);
			if ($page == 0) {
				$page = 1;
			}
		} else {
			$page = 1;
		}
		
		if ($this->type) {  //если выбрали товар по назначению
			if (!$this->id) {  //но нет id,то возвращает саму себя
				return;
			}
			$pager = new Pager(  //иначе выводим по принципу, как для постраничной навигации товаров
				$page,
				'tovar',
				array($this->type.'_id' => $this->id, 'publish' => 1),
				'tovar_id',
				'ASC',
				QUANTITY,
				QUANTITY_LINKS
			);
			$this->krohi = $this->ob_m->get_krohi($this->type, $this->id);  //выводим хлебные крошки
			$this->keywords = $this->krohi[0][$this->type.'_name'].','.$this->krohi[1]['brand_name'];
			$this->discription = $this->krohi[0][$this->type.'_name'].','.$this->krohi[1]['brand_name'];

		} elseif ($this->parent) {  //если кликаем на родительскую категорию
			if (!$this->id) {
				return;
			}
			$ids = $this->ob_m->get_child($this->id);  // возвращаем все id товаров, которые входят в эту родительскую категорию
			
			if (!$ids) {
				return;
			}
			
			$pager = new Pager(  //для постраничной навигации товаров, когда выводим родительскую категорию - SELECT * FROM tovar WHERE brand_id IN($Iids) AND publish=1
				$page,
				'tovar',
				array('brand_id' => $ids, 'publish' => 1),
				'tovar_id',
				'ASC',
				QUANTITY,
				QUANTITY_LINKS,
				array("IN", "=")
			);
			$this->type = "parent";
			
			$this->krohi = $this->ob_m->get_krohi('brand', $this->id);
			$this->keywords = $this->krohi[0]['brand_name'];
			$this->discription = $this->krohi[0]['brand_name'];

		} elseif (!$this->type && !$this->parent) {  //если не выбрали по типу и не родительскую категорию, просто нажали на ссылку "Каталог товаров"
			$pager = new Pager(
				$page,
				'tovar',
				array('publish' => 1),
				'tovar_id',
				'ASC',
				QUANTITY,
				QUANTITY_LINKS
			);
			$this->krohi[0]['brand_name'] = "Каталог";
			$this->keywords = "Промэнерго, каталог товаров";
			$this->discription = "Промэнерго, каталог товаров";
			
		}
		if (is_object($pager)) {//является ли $pager объектом?
			$this->navigation = $pager->get_navigation();
			$this->catalog = $pager->get_posts();
			
		}
		
	}
	
	protected function output()
	{
		
		$previous = FALSE;
		if ($this->type && $this->id) {  //если есть какое-то значение в type и в id, то пристыковываем к ссылке на постраничной навигации
			$previous = "/".$this->type."/".$this->id;
		}
		
		$this->content = $this->render(VIEW.'catalog_page', array(
			'catalog' => $this->catalog,
			'navigation' => $this->navigation,
			'previous' => $previous,
			'krohi' => $this->krohi
		));
		
		$this->page = parent::output();
		return $this->page;
	}
	
	
}