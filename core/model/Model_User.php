<?php

/*
 * Модель, для работы с юзерами
 */

class Model_User
{
	protected $ins_driver_u;  //объект класса Model Driver
	protected $user_id;  //id зера
//	protected $glue = "|";
//
//	private $td;
//	private $cyfer = MCRYPT_BLOWFISH;
//	private $mode = MCRYPT_MODE_CFB;
//	private $created;
//	private $version;
	
	
	static $instance;
	
	//static $cookie_name = 'USERNAME';
	
	static function get_instance()
	{
		if (self::$instance instanceof self) {
			return self::$instance;
		}
		return self::$instance = new self;
	}
	
	private function __construct()
	{
		$this->ins_driver_u = Model_Driver::get_instance();
	}
	
	public function get_user($name, $password)  //получаем id юзера по его имени и паролю из бд
	{
		
		$result = $this->ins_driver_u->select(
			array('user_id'),
			'users',
			array('login' => $name,
				'password' => md5($password)
			)
		);
		if ($result == NULL || $result == FALSE) {  //если вернул ничего или ошибочные данные
			throw new AuthException('Пользователь с такими данными не найден');
			return;
		}
		
		if (is_array($result)) {  //если это массив
			return $result[0]['user_id'];
		}
	}
	
	public function get_fealtures($ip)  //вытаскиваем ip юзера из бд
	{
		$result = $this->ins_driver_u->select(
			array('fealtures'),
			'fealtures',
			array('ip' => $ip)
		);
		if (count($result) == 0) {
			return NULL;
		}
		
		return $result[0]['fealtures'];
	}
	
	public function insert_fealt($ip)  //вставляет единицу в бд, что юзер с таким ip ввел неверные данные,если до этого неверных попыток не было
	{
		$this->ins_driver_u->insert(
			'fealtures',
			array('fealtures', 'ip', 'time'),
			array('1', $ip, time()));
	}
	
	public function update_fealt($ip, $fealtures)  //если до этого была минимум одна неверная попытка,обновляет данные в бд
	{
		$fealtures++;
		$this->ins_driver_u->update(
			'fealtures',  //какая таблица
			array('fealtures', 'time'),  //какие поля
			array($fealtures, time()),  //что в них вставляем
			array('ip' => $ip)  //фильтрация по ip
		);
	}
	
	public function clean_fealtures($time)  //очистка данных из таблицы неправильных попыток
	{ //удаляем все записи из таблицы fealtures, где поле time <= $time
		$this->ins_driver_u->delete(
			'fealtures',
			array('time' => $time),
			array('<=')
		);
	}
	
	public function check_id_user($id = FALSE)  //записываем id юзера в свойство user_id модели Model_User
	{
		if ($id) {  //если id передан
			return $this->user_id = $id;
		}
		else {  //иначе
//			if (array_key_exists(self::$cookie_name, $_COOKIE)) {
//				$this->unpackage($_COOKIE[self::$cookie_name]);
//			} else {
//				throw new AuthException('Доступ запрещен');
//			}
		}
	}
}