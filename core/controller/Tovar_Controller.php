<?php
defined('PROM') or exit('Access denied');
/*
 * класс вывода детальной страницы с описанием товара
 */

class Tovar_Controller extends Base
{
	protected $tovar;//  массив полного описания товара
	protected $krohi;

	protected function input($param = array())
	{
		parent::input();

		if (isset($param['id'])) {
			$id = $this->clear_int($param['id']);
			if ($id) {
				$this->tovar = $this->ob_m->get_tovar($id);

				$this->title .= $this->tovar['title'];
				$this->keywords = $this->tovar['keywords'];
				$this->discription = $this->tovar['discription'];
				$this->krohi[0]['tovar_name'] = $this->tovar['title'];
			}
		}

	}

	protected function output()
	{

		$this->content = $this->render(VIEW.'tovar_page', array(
			'tovar' => $this->tovar,
			'krohi' => $this->krohi
		));

		$this->page = parent::output();
		return $this->page;
	}
}