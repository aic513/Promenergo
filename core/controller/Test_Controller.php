<?php

/*
 * Тестовый контроллер
 */

class Test_Controller extends Base
{

	public function input($param = array())  //берет данные на вход
	{
		if ($param[ 'page' ]) {
			$page = $param[ 'page' ];
		} else {
			$page = 1;
		}
		$pager = new Pager($page,
			'tovar',
			array('publish' => 1),
			'tovar_id',
			'ASC',
			QUANTITY,
			QUANTITY_LINKS);
		echo '<pre>';
		var_dump($pager->get_navigation());
		echo '</pre>';
	}



	public function output()  //выдает данные на выход
	{

	}
}