<?php

/*
 * Контроллер для полнотекстового поиска по сайту
 */

class Search_Controller extends Base
{

	protected $str;  //свойство строки поискового запроса

	protected $navigation;  //массив ссылок для постраничной навигации

	protected $search;  //массив данных для вывода на экран

	protected function input($param = array())
	{
		parent::input();

		if (isset($param['page'])) {
			$page = $this->clear_int($param['page']);

			if ($page == 0) {
				$page = 1;
			}
		} else {
			$page = 1;
		}

		if (isset($param['str'])) {  //если в адресной строке был передан параметр str
			$this->str = rawurldecode($this->clear_str($param['str']));
		} elseif ($this->is_post()) {  //а если не из адресной строки,то принимаем данные из $_POST
			$this->str = $this->clear_str($_POST['txt1']);
		}

		$this->title .= "Результаты поиска по запросу - ".$this->str;

		$this->keywords .= "Поиск, промэнерго";
		$this->discription .= "Результаты поиска по запросу - ".$this->str;

		$pager = new Pager(  //выводим данные для постраничной навигации  SELECT * FROM WHERE publish=1 AND MATCH ('title,text') AGAINST ('str')
			$page,
			'tovar',
			array('publish' => 1),
			'tovar_id',
			'ASC',
			QUANTITY,
			QUANTITY_LINKS,
			array("="),
			array('title,text' => $this->str)
		);

		if (is_object($pager)) {  //является ли $pager объектом?
			$this->navigation = $pager->get_navigation();
			$this->search = $pager->get_posts();
			$this->str = rawurlencode($this->str);  //шифруем запрос в адресной строке
		}

		$this->right_side = FALSE;
	}

	protected function output()
	{


		$this->content = $this->render(VIEW.'search_page',
			array(
				'search' => $this->search,
				'navigation' => $this->navigation,
				'str' => $this->str
			));

		$this->page = parent::output();

		return $this->page;
	}
}

?>