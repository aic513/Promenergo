<?php

/*
 * Класс для админки
 */

class Admin_Controller extends Base_Admin
{
	protected $pages; //массив страниц
	protected $home;  //главная страница
	protected $contacts;  //страница контактов
	protected $message;  //информационные сообщения

	protected function input($param = array())
	{
		parent::input();
		$this->title .= 'Редактирование странц';
		$this->pages = $this->ob_m->get_pages(true);  //получаем все страницы сайта для селектов справа в админке
		$home = $this->ob_m->get_home_page();  //получаем главную странцу
		if (is_array($home)) {
			$this->home = $home['page_id'];
		}
		
		$contacts = $this->ob_m->get_contacts();  //получаем стараницу контактов
		if (is_array($contacts)) {
			$this->contacts = $contacts['page_id'];
		}
		
		if ($this->is_post()) {
			$id = $this->clear_int($_POST['id']);
			$title = $_POST['title'];
			$text = $_POST['text'];
			$keywords = $_POST['keywords'];
			$discription = $_POST['discription'];
			$position = $this->clear_int($_POST['position']);
			
			if (!empty($title) && !empty($text)) {
				if ($_POST['add_x']) {
					$result = $this->ob_m->add_page(
						$title,
						$text,
						$position,
						$keywords,
						$discription
					);
					if ($result === TRUE) {
						$_SESSION['message'] = "Новая страница успешно добавлена";
						$this->message = $_SESSION['message'];
					} else {
						$_SESSION['message'] = "Ошибка добавления данных";
					}
//					$this->message = $_SESSION['message'];
//					print_r($this->message);
					header("Location:".SITE_URL."admin");
					exit();
				}
				
			}

		}
		
	}
	
	
	protected function output()
	{
		
		$this->content = $this->render(
			VIEW.'admin/edit_pages',
			array(
				'pages'=>$this->pages,
				'home' => $this->home,
				'contacts' =>$this->contacts,
				'message' => $this->message,
			)
		);

//		unset($_SESSION['message']);
		$this->page = parent::output();
		return $this->page;
	}
}

?>