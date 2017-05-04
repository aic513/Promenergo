<?php
defined('PROM') or exit('Access denied');
/*
 * Контроллер, который будет показывать ошибки на сайте
 */

class Error_Controller extends Base_Error
{
	
	protected function input($param = array())
	{
		parent::input();
		
		$er = '';
		$arr = array();
		if (isset($param['mes'])) {  //есть ли в $param ячейка mes? Если до,то принимаем это значение из адресной строки
			foreach ($param as $key => $val) {  //пробегаемся по этим параметрам
				$val = $this->clear_str(rawurldecode($val));  //
				$arr[] = $val;
				
				$er .= $key.' - '.$val.'|';
				
			}
			
			if ($_SESSION['error']) {
				foreach ($_SESSION['error'] as $k => $v) {
					$er .= $k.' - '.$v.'|';
				}
			}
			unset($_SESSION['error']);
			$this->error = $er;
			$this->message_err = $arr;
		}
	}
	
	protected function output()
	{
		$this->page = parent::output();
		
		return $this->page;  //готовый шаблон для вывода на экран
	}
}

?>