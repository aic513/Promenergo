<?php

/*
 * Класс для постраничной навигации
 * Класс вспомогательный, поэтому не наследуем от класс Base
 * Он сделан,как сторонняя библиотека,поэтому лежит в /lib
 */

class Pager
{
	protected $page;  //номер текущей страницы
	protected $tablename;  //имя таблицы
	protected $where;  //критерий о том,является ли запись опубликованной или нет
	protected $order;  //сортировка
	protected $to;  //направление сортировки
	protected $operand;  //операнд для оператор сравнения
	protected $match;  //массив для полнотекстового поиска
	protected $post_number;  //количество записей, которое будет выводиться на одной странице, константа QUANTITY
	protected $number_link;  //количество ссылок от текущей страницы, константа QUANTITY_LINKS
	protected $db;  //объект класс Model_Driver
	protected $total_count;  //общее количество записей
	
	public function __construct(
		$page,
		$tablename,
		$where = array(),
		$order = '',
		$napr = '',
		$post_number,
		$number_link,
		$operand = "=",
		$match = array()
	)
	{    //записываем данные переменные в свойства нашего класса
		$this->page = $page;
		$this->tablename = $tablename;
		$this->where = $where;
		$this->order = $order;
		$this->napr = $napr;
		$this->post_number = $post_number;
		$this->number_link = $number_link;
		$this->operand = $operand;
		$this->match = $match;
		
		
		$this->db = Model_Driver::get_instance();
	}
	
	public function get_total()  //метод подсчитывает количество данных в бд, которые нужно вывести,возвращает число
	{
		if (!$this->total_count) {
			
			$result = $this->db->select(
				array("COUNT(*) as count"),  //количество записей
				$this->tablename,
				$this->where,
				$this->order,
				$this->to,
				FALSE,
				$this->operand,
				$this->match
			);
			$this->total_count = $result[ 0 ][ 'count' ];
		}
		
		return $this->total_count;
	}
	
	public function get_posts()  //возвращает массив данных, которые необходимо вывести на экран, сформирует первые 3 записи и выведет их на экран
	{
		$total_post = $this->get_total();  //сохраняем количество данных
		
		$number_pages = (int)($total_post / $this->post_number);  //делим количество данных из бд на количество данных на одной странице, получаем номер страницы
		
		if (($total_post % $this->post_number) != 0) {   //если не делится нацело, то уведличиваем количество страниц на единицу
			$number_pages++;
		}
		
		if ($this->page <= 0 || $this->page > $number_pages) {  //если номер страницы меньше нуля или номер страницы > больше,чем количество страниц
			return FALSE;
		}
		$start = ($this->page - 1) * $this->post_number;  //начало ограничения выборки для LIMIT
		

		$result = $this->db->select(  //SELECT * FROM tovar WHERE publish=1 ORDER by tovar_id ASC  LIMIT ($start,$this->post_number)
			array('*'),
			$this->tablename,
			$this->where,
			$this->order,
			$this->to,
			$start . ',' . $this->post_number,
			$this->operand,
			$this->match
		);
		
		return $result;
	}

	public function get_navigation()  //возвращает массив постраничной навигации
	{
		$total_post = $this->get_total();  //общее количество записей, которые необходимо вывести на экран

		$number_pages = (int)($total_post / $this->post_number);  //общее количество страниц

		if (($total_post % $this->post_number) != 0) {
			$number_pages++;
		}

		if ($total_post < $this->post_number || $this->page > $number_pages) {  //если количество записей меньше, чем количество записей на одной странице или номер страницы больше, чем общее количество страниц 
			return FALSE;
		}

		$result = array();

		if ($this->page != 1) {  //если номер страницы !=1, то нужно создать ссылки на первую и на последнюю страницы
			$result[ 'first' ] = 1;
			$result[ 'last_page' ] = $this->page - 1;
		}

		if ($this->page > $this->number_link + 1) {  //если текущая страница > чем колчество ссылок по обеим бокам текущей страницы + 1, расшифровка: текущая 5, значит будет first<2345
			for ($i = $this->page - $this->number_link; $i < $this->page; $i++) {
				$result[ 'previous' ][] = $i;
			}
		} else {  //иначе будет просто 321
			for ($i = 1; $i < $this->page; $i++) {
				$result[ 'previous' ][] = $i;
			}
		}

		$result[ 'current' ] = $this->page;  //текущая страницы

		if ($this->page + $this->number_link < $number_pages) {  //если номер текущей страницы + количество ссылок по обеим бокам от текущей страницы < чем общее количество страниц
			for ($i = $this->page + 1; $i <= $this->page + $this->number_link; $i++) {
				$result[ 'next' ][] = $i;
			}
		} else {  //иначе выводит ссылки,если последняя ссылка является ссылкой на последнюю страницу
			for ($i = $this->page + 1; $i <= $number_pages; $i++) {
				$result[ 'next' ][] = $i;
			}
		}

		if ($this->page != $number_pages) {  //если номер страницы не равен общему количеству страниц,то не выводим ссылки на 'последняя' и на номер последней страницы
			$result[ 'next_pages' ] = $this->page + 1;
			$result[ 'end' ] = $number_pages;
		}

		return $result;
	}
	
	
}