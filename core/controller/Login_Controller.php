<?php

/*
 * Класс, отвечающий за авторизацию пользователей,выводит страницу авторизации
 */

class Login_Controller extends Base_Admin
{
	protected $ob_us;  //хранит объект модели юзера
	
	protected function input($param = array())
	{
		$this->user = FALSE;
		parent::input();

		$this->ob_us = Model_User::get_instance();  //получаем объект класс Model_User

		if (isset($param['logout'])) {  //если в админке нажали на кнопку выйти
			$logout = $this->clear_int($param['logout']);

			if ($logout) {
				$res = $this->ob_us->logout();
				if ($res) {
					header("Location:".SITE_URL."index");
					exit();
				}
			}
		}
		
		/*
		 * Очистка всех юзеров, которые были заблокированы
		 */
		$time_clean = time() - (3600 * 24 * FEALT);  //от сегодняшней даты вычитаем количество секунд, на которое заблоикрован юзер
		$this->ob_us->clean_fealtures($time_clean);  //удаляем данные из таблицы неправильных попыток
		
		$ip_u = $_SERVER['REMOTE_ADDR'];  //ip пользователя
		$fealtures = $this->ob_us->get_fealtures($ip_u);  //количество неправильных попыток ввода имени и пароля
		if ($this->is_post()) {  //отправлены ли данные методом POST?
			if (
				isset($_POST['name'])
				&& isset($_POST['password'])
				&& $fealtures < 3
			) {  //передал ли пользователь заполенные данные имени и пароля в полях, и не ошибся ли он 3 раза при вводе данных?
				$name = $this->clear_str($_POST['name']);
				$password = $this->clear_str($_POST['password']);
				try {
					$id = $this->ob_us->get_user($name, $password);
					$this->ob_us->check_id_user($id);  //записываем id юзера в свойсво модели $user_id
					$this->ob_us->set();  //записываме данные юзера в куки
					header("Location:".SITE_URL."admin");  //перенаправляем в админку
					exit();
					
				} catch (AuthException $e) {
					if ($fealtures == NULL) {  //если количество неправильных попыток равно нулю, то значит юзер еще не вводил неправильные данные
						$this->ob_us->insert_fealt($ip_u);  //вставляем данные в бд
					} elseif ($fealtures > 0) {  //если количество неправильных попыток больше нуля
						$this->ob_us->update_fealt($ip_u, $fealtures);  //обновляем данные в бд
					}
				}
			}
		}
	}
	
	protected function output()
	{
		$this->content = $this->render(VIEW.'admin/login_page',
			array('error' => $_SESSION['auth']));
		$this->page = parent::output();
		unset($_SESSION['auth']);
		return $this->page;
	}
}