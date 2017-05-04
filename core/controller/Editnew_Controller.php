<?php
defined('PROM') or exit('Access denied');
/*
 * Класс для работы с новостями из админки, делаем по аналогии с Admin_Controller
 */

class Editnew_Controller extends Base_Admin
{
	protected $news;
	protected $navigation;
	protected $option = 'add';
	protected $news_text;
	protected $data;

	protected function input($param = array())
	{
		parent::input();

		///////

		if ($this->is_post()) {

			$id = $_POST['id'];
			$title = $_POST['title'];
			$anons = $_POST['anons'];
			$text = $_POST['text'];
			$keywords = $_POST['keywords'];
			$discription = $_POST['discription'];

			if (!empty($title) && !empty($text) && !empty($anons)) {
				if ($_POST['add_news_x']) {
					$result = $this->ob_m->add_news(  //добавление новости
						$title,
						$text,
						$anons,
						$keywords,
						$discription
					);
					if ($result === TRUE) {
						$_SESSION['message'] = 'Новость добавлена';
					} else {
						$_SESSION['message'] = 'Ошибка при добавлении новости';
					}
					header("Location:".SITE_URL.'editnew');
					exit();
				}
				if ($_POST['edit_news_x']) {
					$result = $this->ob_m->edit_news(  //редактирование новости
						$title,
						$text,
						$anons,
						$id,
						$keywords,
						$discription
					);

					if ($result === TRUE) {
						$_SESSION['message'] = "Новость успешно обновлена";
					} else {
						$_SESSION['message'] = "Ошибка обновления новсти";
					}
					header("Location:".SITE_URL.'editnew/id/'.$id);
					exit();
				}
			} else {

				$_SESSION['message'] = 'Вы должны заполнить обязательные поля (текст, заголовок, анонс)<br />';
				if (empty($title)) {
					$_SESSION['message'] .= "Заполните заголовок<br />";
				} else {
					$_SESSION['data']['title'] = $title;
				}
				if (empty($anons)) {
					$_SESSION['message'] .= "Заполните анонс<br />";
				} else {
					$_SESSION['data']['anons'] = $anons;
				}
				if (empty($text)) {
					$_SESSION['message'] .= "Заполните text<br />";
				} else {
					$_SESSION['data']['text'] = $text;
				}
				$_SESSION['data']['keywords'] = $keywords;
				$_SESSION['data']['discription'] = $discription;
				$this->data = $_SESSION['data'];

				if ($_POST['add_news_x']) {
					header("Location:".SITE_URL.'editnew');
					exit();
				} elseif ($_POST['edit_news_x']) {
					header("Location:".SITE_URL.'editnew/id/'.$id);
					exit();
				}

			}
		}
		///////


		if (isset($param['id'])) {
			$id = $this->clear_int($param['id']);

			if ($param['option'] == 'delete') {  //удаление новости
				$result = $this->ob_m->delete_news($id);

				if ($result === TRUE) {
					$_SESSION['message'] = 'Новость удалена';
				} else {
					$_SESSION['message'] = 'Ошибка при удалении новости';
				}
				header("Location:".SITE_URL.'editnew');
				exit();
			}

			$this->option = 'edit';
			$this->news_text = $this->ob_m->get_admin_news_text($id);
			//print_r($this->news_text);
			$this->title .= "Добавление новости - ".$this->news_text['title'];


		}
		if (isset($param['page'])) {
			$page = $this->clear_int($param['page']);
			if (!$page) {
				$page = 1;
			}
		} else {
			$page = 1;
		}

		$pager = new Pager($page, 'news', array(), 'date', 'DESC', 4, QUANTITY_LINKS);  //постраничная навигация по новостям
		$this->news = $pager->get_posts();
		$this->navigation = $pager->get_navigation();

		$this->message = $_SESSION['message'];

	}

	protected function output()
	{

		$this->content = $this->render(VIEW.'admin/edit_news',
			array(
				'mes' => $this->message,
				'news' => $this->news,
				'navigation' => $this->navigation,
				'news_text' => $this->news_text,
				'option' => $this->option,
				'data' => $this->data
			));
		$this->page = parent::output();

		unset($_SESSION['message']);
		unset($_SESSION['data']);
		return $this->page;
	}

}