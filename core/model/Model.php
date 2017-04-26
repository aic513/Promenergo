<?php

/*
 *Главная модель сайта для получения данных на страницах сайта,каталога,товары,в общем весь контент
 */

class Model
{
	static $instance;
	public $ins_driver;

	static function get_instance()
	{
		if (self::$instance instanceof self) {
			return self::$instance;
		} else {
			return self::$instance = new self;
		}
	}

	private function __construct()
	{
		try {
			$this->ins_driver = Model_Driver::get_instance();
		} catch (DbException $e) {
			exit();
		}
	}

	public function get_news()  //выбрает новости, для правой колонки
	{
		$result = $this->ins_driver->select(
			array('news_id', 'title', 'anons', 'date'),
			'news',
			array(),
			'date',
			'DESC',
			3
		);
		$row = array();
		foreach ($result as $value) {
			$value['anons'] = substr($value['anons'], 0, 255);
			$value['anons'] = substr($value['anons'], 0, strrpos($value['anons'], ' '));

			$row[] = $value;
		}
		return $row;
	}

	public function get_pages($all = FALSE)  //выбирает контент для левой колонки
	{
		if ($all) {  //если выводим список страниц в админке в колонке справа
			$result = $this->ins_driver->select(
				array('page_id', 'title', 'type'),
				'pages',
				array(),
				'position',
				'ASC'
			);
		} else {
			$result = $this->ins_driver->select(  //SELECT page_id,title FROM pages WHERE type IN ('post', 'contacts')
				array('page_id', 'title'),
				'pages',
				array('type' => "'post','contacts'"),
				'position',
				'ASC',
				FALSE,
				array("IN")
			);
		}
		return $result;
	}

	public function get_catalog_type()  //выбирает типы каталога
	{
		$result = $this->ins_driver->select(
			array('type_id', 'type_name'),
			'type'
		);
		return $result;
	}

	public function get_catalog_brands()  //выбирает товар по брендам слева
	{
		$result = $this->ins_driver->select(
			array('brand_id', 'brand_name', 'parent_id'),
			'brands'
		);

		$arr = array();  //создаем новый масиив для более удобного вывода брендов,так как из бд выходит неудобный массив
		foreach ($result as $item) {
			if ($item['parent_id'] == 0) {  //если parent_id==0, значит родительская категория
				$arr[$item['brand_id']][] = $item['brand_name'];  //
			} else {  //иначе дочерняя категория
				$arr[$item['parent_id']]['next_lvl'][$item['brand_id']] = $item['brand_name'];
			}
		}
		return $arr;
	}

	public function get_home_page()  // выбирает контент для домашней страницы
	{
		$result = $this->ins_driver->select(
			array('page_id', 'title', 'text', 'keywords', 'discription'),
			'pages',
			array('type' => 'home'),
			FALSE,
			FALSE,
			1
		);
		return $result[0];
	}

	public function get_header_menu()  //выбирает меню для хедера  SELECT type_id,type_name FROM type WHERE in_header IN ('1','2','3','4')
	{
		$result = $this->ins_driver->select(
			array('type_id', 'type_name'),
			'type',
			array('in_header' => "'1','2','3','4'"),
			'in_header',
			'ASC',
			4,
			array('IN')
		);
		$row = array();
		foreach ($result as $item) {
			$item['type_name'] = str_replace(" ", "<br />", $item['type_name']);  //добавляем перенос строки между словами
			$item['type_name'] = mb_convert_case($item['type_name'], MB_CASE_UPPER, "UTF-8");  //меняем регистр букв на верхний
			$row[] = $item;
		}

		return $row;

	}

	public function get_news_text($id)  //получаем одну новость по id
	{
		$result = $this->ins_driver->select(    //SELECT  'title', 'text', 'date', 'keywords', 'discription' FROM news WHERE 'news_id' => $id
			array('title', 'text', 'date', 'keywords', 'discription'),
			'news',
			array('news_id' => $id)
		);
		return $result[0];
	}

	public function get_page($id)   //получаем полный текст страниц
	{
		$result = $this->ins_driver->select(  //SELECT  'title', 'text', 'date', 'keywords', 'discription' FROM pages WHERE 'news_id' => $id
			array('title', 'keywords', 'discription', 'text'),
			'pages',
			array('page_id' => $id)
		);
		return $result[0];
	}

	public function get_contacts()  //получаем страницу контактов по клику на иконку контакты
	{
		$result = $this->ins_driver->select(
			array('page_id', 'title', 'text', 'keywords', 'discription'),
			'pages',
			array('type' => 'contacts')
		);
		return $result[0];
	}

	public function get_child($id)  //получаем id всех потомков, которые входят в данную родительскую категорию
	{
		$result = $this->ins_driver->select(
			array('brand_id'),
			'brands',
			array('parent_id' => $id)
		);
		if ($result) {
			$row = array();
			foreach ($result as $item) {  //упрощаем массив
				$row[] = $item['brand_id'];
			}
			$row[] = $id;

			$res = implode(",", $row);

			return $res;
		} else {
			return FALSE;
		}

	}

	public function get_krohi($type, $id)  //выбирает данные для хлебных крошек в каталоге товаров
	{
		if ($type == 'type') {
			$sql = "SELECT type_id, type_name
					FROM type
					WHERE type_id = $id";
		}

		if ($type == "brand") {
			//где brand_id=id бренда в родительской категории
			$sql = "(SELECT brand_id,brand_name
					FROM brands
					WHERE brand_id = (SELECT parent_id FROM brands WHERE brand_id = $id))  
					UNION
					(SELECT brand_id, brand_name FROM brands WHERE brand_id = $id)";
		}
		$result = $this->ins_driver->ins_db->query($sql);

		if (!$result) {
			throw new DbException("Ошибка базы данных".$this->ins_driver->ins_db->errno."|".$this->ins_driver->ins_db->error);
		}
		if ($result->num_rows == 0) {
			return FALSE;
		}
		$row = array();

		for ($i = 0; $i < $result->num_rows; $i++) {
			$row[] = $result->fetch_assoc();
		}

		return $row;
	}

	public function get_tovar($id)  //получаем товар по id
	{
		$result = $this->ins_driver->select(
			array('title', 'text', 'img', 'keywords', 'discription'),
			'tovar',
			array('tovar_id' => $id, 'publish' => 1)
		);
		return $result[0];
	}

	public function get_pricelist()  //получаем данные для прайс-листа в excel
	{
		$sql = "
				SELECT brands.brand_id,
						brands.brand_name,
						brands.parent_id,
						tovar.title,
						tovar.anons,
						tovar.price
						FROM brands
				LEFT JOIN tovar
					ON tovar.brand_id=brands.brand_id
				WHERE brands.brand_id
					IN( /*Этот запрос выберет id родительских категорий, если у их дочерних категорий есть какой-то товар*/
						SELECT brands.parent_id FROM tovar 
						LEFT JOIN brands ON tovar.brand_id=brands.brand_id
						WHERE tovar.publish='1'
					)
					OR brands.brand_id
					IN ( /*Этот запрос выберет id дочерних категорий, если у них категорий есть какой-то товар*/
						SELECT brands.brand_id
							 FROM tovar 
							 LEFT JOIN brands 
							 	ON tovar.brand_id=brands.brand_id 
							WHERE tovar.publish='1'
						)
					AND  tovar.publish='1'
				
				";
		$result = $this->ins_driver->ins_db->query($sql);  //выполняем запрос

		if (!$result) {
			throw new DbException("Ошибка базы данных : ".$this->ins_driver->ins_db->errno."|".$this->ins_driver->ins_db->error);
		}
		if ($result->num_rows == 0) {
			return FALSE;
		}

		$myrow = array();  //выходной массив

		for ($i = 0; $i < $result->num_rows; $i++) {  //приводим массив к удобочитаемому виду
			$row = $result->fetch_assoc();

			if ($row['parent_id'] === '0') {  //если категория родительская
				if (!empty($row['title'])) {  //если поле title не пустое - товары есть
					$myrow[$row['brand_id']][$row['brand_name']][] = array(
						'title' => $row['title'],
						'anons' => $row['anons'],
						'price' => $row['price']

					);
				} else {  //иначе товары есть
					$myrow[$row['brand_id']][$row['brand_name']] = array();  //формируем пустой массив
				}
			} else {    //если категория дочерняя
				$myrow[$row['parent_id']]['sub'][$row['brand_name']][] = array(
					'title' => $row['title'],
					'anons' => $row['anons'],
					'price' => $row['price']

				);
			}

		}

		return $myrow;
	}

	public function add_page($title, $text, $position, $keywords, $discription)  //добавление инфы в в админке
	{
		$result = $this->ins_driver->insert(
			'pages',
			array('title', 'text', 'position', 'keywords', 'discription'),
			array($title, $text, $position, $keywords, $discription)
		);
		return $result;
	}
	
}