<?php

/*
 * Класс, который формирует основные запросы к БД и выполняет их на сервере
 * Какие-то специфичноые запросы уже будут описаны непосредственно в классах Model/Model_User
 */

class Model_Driver
{
	static $instance;
	public $ins_db;  //здесь хранится объект расширения mysqli
	
	static function get_instance()
	{
		if (self::$instance instanceof self) {
			return self::$instance;
		} else {
			return self::$instance = new self;
		}
	}
	
	public function __construct()  //подключаемся к бд
	{
		$this->ins_db = new mysqli(HOST, USER, PASSWORD, DB_NAME);
		if ($this->ins_db->connect_error) {  //Если соединиться не удалось-покажет какая именно была ошибка
			throw new DbException ('Ошибка соединения с бд: '
				.$this->ins_db->connect_errno.'|'
				.$this->ins_db->connect_error);
		}
		
		$this->ins_db->query("SET NAMES utf8");   //устанавливаем кодировку
		
	}
	
	public function select(   //пишем функцию выборки данных SELECT
		$param,    //какие параметры передаем в метод
		$table,    //какая таблица
		$where = array(),  //критерий
		$order = FALSE,  //сортировка
		$to = 'ASC',  //направление сортировки
		$limit = FALSE,  //ограничитель вывода
		$operand = array(' = '), //операнды сравнения
		$match = array()  //для полнотекстового поиска  FULLTEXT
	)
	{
		
		$sql = "SELECT";
		foreach ($param as $item) {  //проходимся по параметрам
			$sql .= ' '.$item.',';
		}
		
		$sql = rtrim($sql, ',');  //отрезаем в конце запятрую
		$sql .= ' '.'FROM'.' '.$table;   //из какой таблицы выбираем данные
		if (count($where) > 0) {  //проверяем,нужно ли фильтровать данные?
			$ii = 0;  //для контроля цикла задаем переменную
			foreach ($where as $key => $value) {
				if ($ii == 0) {  //если нулевая итерация
					if ($operand[$ii] == "IN") {  //если в операторах сравнения присутствует IN
						$sql .= " WHERE ".strtolower($key)." ".$operand[$ii]."(".$value.")";
					} else {  //если в операторах сравнения не присутствует IN
						$sql .= ' '.' WHERE '.strtolower($key).' '.$operand[$ii].' '."'".$this->ins_db->real_escape_string($value)."'";
					}
				}
				if ($ii > 0) { // на следующей операции цикла WHERE уже не пишем,так как употребляет в запросе только один раз
					if ($operand[$ii] == "IN") {
						$sql .= " AND ".strtolower($key)." ".$operand[$ii]."(".$value.")";
					} else {
						$sql .= ' '.' AND '.strtolower($key).' '.$operand[$ii].' '."'".$this->ins_db->real_escape_string($value)."'";
					}
					
				}
				$ii++;    //чтобы с каждой итерацией цикла менялись значения ключей в массиве переданных операндов (<,>,= и т.д.)
				if ((count($operand) - 1) < $ii) {   //если количество операндов меньше,чем количество критериев
					$operand[$ii] = $operand[$ii - 1];  //то для предыдуего критерия будет браться предыдущий операнд
				}
			}
			
		}
		
		if (count($match) > 0) {  //условие для полнотекстового поиска, есть ли какие-то ячейки в массиве $match
			foreach ($match as $k => $v) {
				if (count($where) > 0) {  // если были какие - то условия для WHERE, то выводим их,напрмиер WHERE publish1 MATCH и т . д .
					$sql .= " AND MATCH (".$k.") AGAINST('".$this->ins_db->real_escape_string($v)."')";
				} elseif (count($where) == 0) {  //если криетриев не было, сразу выводим WHERE MATCH
					$sql .= " WHERE MATCH (".$k.") AGAINST('".$this->ins_db->real_escape_string($v)."')";
				}
			}
		}
		
		if ($order) {  //для сортировки
			$sql .= ' ORDER BY '.$order." ".$to.' ';
		}
		
		if ($limit) {  //для ограничения вывода
			$sql .= " LIMIT ".$limit;
		}
		
		$result = $this->ins_db->query($sql);   //десь лежит результат запроса
		
		if (!$result) {
			//  throw new DbException("Ошибка запроса".$this->ins_db->connect_errno."|".$this->ins_db->connect_error);
		}
		
		if ($result->num_rows == 0) {  //если резудьтат нулевой,возвращаем FALSE
			return FALSE;
		}
		
		for ($i = 0; $i < $result->num_rows; $i++) {
			$row[] = $result->fetch_assoc();  // в $row записываем результат запроса в виде ассоциативного массива
		}
		
		return $row;
		exit();

//        echo $sql . '<br>';
//        var_dump($operand);
//        exit();
	}
}