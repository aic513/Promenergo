<?php

/*
 * Класс для управления типами из админки
 */

class Edittypes_Controller extends Base_Admin
{

	protected $brands;
	protected $message;
	protected $option = 'view';
	protected $id;
	protected $data_type;
	protected $type;

	protected function input($param = array())
	{
		parent::input();

		$this->title .= 'Админка - типы';

		if ($param['option'] == 'edit') {
			$this->option = 'edit';
			if ($param['id']) {
				$this->id = $this->clear_int($param['id']);
				$this->type = $this->ob_m->get_type_adm($this->id);
			}
		}


		if ($param['option'] == 'delete') {
			if ($param['id']) {
				$id = $this->clear_int($param['id']);
				if ($id) {
					$result = $this->ob_m->delete_types($id);

					if ($result === TRUE) {
						$_SESSION['message'] = "Тип товара успешно удален";
					} else {
						$_SESSION['message'] = "Ошибка удаления товара";
					}

					header("Location:".SITE_URL.'edittypes');
					exit();
				}
			}
		}

		if ($this->is_post()) {


			$type_name = $_POST['type_name'];
			$in_header = $_POST['in_header'];
			$id = $this->clear_int($_POST['id']);

			if ($this->option == 'edit') {
				if (empty($type_name)) {
					$_SESSION['message'] = "Заполните заголовок типа товара";
					header("Location:".SITE_URL.'edittypes/option/edit/id/'.$id);
					exit();
				} else {
					$result = $this->ob_m->edit_types($type_name, $in_header, $id);

					if ($result === TRUE) {
						$_SESSION['message'] = "Тип товара успешно изменен";
					} else {
						$_SESSION['message'] = "Ошибка изменения типа товара";
					}

					header("Location:".SITE_URL.'edittypes');
					exit();
				}
			}
		}

		$this->brands = $this->ob_m->get_catalog_brands();
		$this->data_type = $this->ob_m->get_catalog_type();

		$this->message = $_SESSION['message'];
	}

	protected function output()
	{

		$this->content = $this->render(VIEW.'admin/edit_types', array(
				'brands' => $this->brands,
				'mes' => $this->message,
				'option' => $this->option,
				'data_type' => $this->data_type,
				'type' => $this->type
			)
		);

		$this->page = parent::output();
		unset($_SESSION['message']);
		return $this->page;
	}
}

?>