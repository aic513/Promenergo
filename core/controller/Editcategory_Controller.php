<?php
defined('PROM') or exit('Access denied');
/*
 *Класс для управления категориями
 */

class Editcategory_Controller extends Base_Admin
{
	protected $brands;
	protected $parents_cat;  //массив родительских категорий
	protected $message;
	protected $option = 'add';
	protected $id;
	protected $category;

	protected function input($param = array())
	{
		parent::input();
		$this->title .= 'Админка - категории';

		if ($param['option'] == 'edit') {
			$this->option = 'edit';
			if ($param['id']) {
				$this->id = $this->clear_int($param['id']);
				$this->category = $this->ob_m->get_category($this->id);
			}
		}
		if ($param['option'] == 'delete') {
			if ($param['id']) {
				$id = $this->clear_int($param['id']);
				if ($id) {
					$result = $this->ob_m->delete_category($id);

					if ($result === TRUE) {
						$_SESSION['message'] = "Категория успешно удалена";
					} else {
						$_SESSION['message'] = "Ошибка удаления категории";
					}

					header("Location:".SITE_URL.'editcatalog');
					exit();
				}
			}
		}

		if ($this->is_post()) {

			$title = $_POST['title'];
			$parent = $_POST['parent'];
			$id = $this->clear_int($_POST['id']);

			if ($this->option == 'add') {

				if (empty($title)) {
					$_SESSION['message'] = "Заполните заголовок категории";
					header("Location:".SITE_URL.'editcategory/option/add');
					exit();
				}

				$result = $this->ob_m->add_category($title, $parent);

				if ($result === TRUE) {
					$_SESSION['message'] = "Категория успешно добавлена";
				} else {
					$_SESSION['message'] = "Ошибка добавления категории";
				}

				header("Location:".SITE_URL.'editcategory/option/add');
				exit();
			}

			if ($this->option == 'edit') {
				if (empty($title)) {
					$_SESSION['message'] = "Заполните заголовок категории";
					header("Location:".SITE_URL.'editcategory/option/edit/'.$id);
					exit();
				} else {
					$result = $this->ob_m->edit_category($title, $parent, $id);

					if ($result === TRUE) {
						$_SESSION['message'] = "Категория успешно изменена";
					} else {
						$_SESSION['message'] = "Ошибка изменения категории";
					}

					header("Location:".SITE_URL.'editcategory/option/edit/id/'.$id);
					exit();
				}
			}
		}
		
		$this->brands = $this->ob_m->get_catalog_brands();
		$this->parents_cat = $this->ob_m->get_parent_brands();

		$this->message = $_SESSION['message'];
	}

	protected function output()
	{
		$this->content = $this->render(VIEW.'admin/edit_category',
			array(
				'brands' => $this->brands,
				'parents_cat' => $this->parents_cat,
				'mes' => $this->message,
				'option' => $this->option,
				'category' => $this->category
			));
		$this->page = parent::output();
		unset($_SESSION['message']);
		return $this->page;
	}
}