<?php
/*
 * Класс для админки
 */

class Admin_Controller extends Base_Admin
{

	protected function input($param = array())
	{
		parent::input();
	}

	protected function output()
	{

		$this->content = $this->render(VIEW.'admin/edit_pages');

		$this->page = parent::output();

		$this->page = parent::output();
		return $this->page;
	}
}

?>