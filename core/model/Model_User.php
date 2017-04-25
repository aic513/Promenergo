<?php

/*
 * Модель, для работы с юзерами
 */

class Model_User
{
	protected $ins_driver_u;  //объект класса Model Driver
	protected $user_id;  //id зера
	protected $glue = "|";  //разделитель для строки в куки
	private $td;  //дескриптор модуля MCRYPT - шифрование данных
	private $cyfer = MCRYPT_BLOWFISH;  //алгоритм шифрования из расширения MCRYPT
	private $mode = MCRYPT_MODE_CFB;  //режим шифрования
	private $created;  //время,которые ватаскиваем из файла-куки
	private $version;  //версия куки,также вытаскиваем из файла-куки
	
	
	static $instance;
	
	static $cookie_name = 'USERNAME';  //имя файла куки
	
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
		$this->td = mcrypt_module_open($this->cyfer, '', $this->mode, '');  //открываем модуль шифрования
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
		} else {  //иначе, если id не сформирован
			if (array_key_exists(self::$cookie_name, $_COOKIE)) {  //есть ли такой ключ в массиве куки?
				$this->unpackage($_COOKIE[self::$cookie_name]);  //получаем расщифрованные куки
			} else {
				throw new AuthException('Доступ запрещен');
			}
		}
	}

	public function set()  //записывает строку в куки
	{
		$cookie_text = $this->package();  //переменная с зашифрованной строкой
		if ($cookie_text) {  //если пришла $cookie_text
			setcookie(self::$cookie_name, $cookie_text, 0, SITE_URL);  //записываем ее в куки
			return TRUE;
		}
	}

	private function package()  //формирует зашифрованную строку для куки
	{
		if ($this->user_id) {  //если есть id
			$arr = array($this->user_id, time(), VERSION);  //массив данных для записи в куки
			$str = implode($this->glue, $arr);  //строка для записи в куки
//			echo $str;
			return $this->encrypt($str);

		} else {
			throw new AuthException("Не найден идентификатор пользователя");
		}
	}

	private function encrypt($str)  //шифрует строку, созданную в методе package()
	{

		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->td), MCRYPT_RAND);  //создаем ветор инициализации шифра

		mcrypt_generic_init($this->td, KEY, $iv);  //открываем буфер обмена
		$crypt_text = mcrypt_generic($this->td, $str);  //здесь лежит шифрованный текст
		mcrypt_generic_deinit($this->td);  //закрываем буфер

		return $iv.$crypt_text;  //полная зашифрованная строка
	}

	private function unpackage($str)  //расшифровывает строку из куки и вытаскиваем все данные из куки(id,время и т.д.)
	{
//		echo $str;
		$result = $this->decrypt($str);  //расшифровываем куку
		list($this->user_id, $this->created, $this->version) = explode($this->glue, $result);  //создаем переменные из массива
		true;  //возвращаем true
	}

	private function decrypt($str)
	{  //метод, который расшифровывает куку
		$iv_size = mcrypt_enc_get_iv_size($this->td);  //получаем длину вектора инициализации
		$iv = substr($str, 0, $iv_size);  //получаем вектор инициализации из зашифрованной строки
		$crypt_text = substr($str, $iv_size);  //получаем шифрованный текст

		mcrypt_generic_init($this->td, KEY, $iv);  //открываем буфр обмена

		$text = mdecrypt_generic($this->td, $crypt_text);  //расшифровываем шифр

		mcrypt_generic_deinit($this->td);  //закрываем буфер

		return $text;  //возвращаем расшифрованную строку
	}

	public function validate_cookie()  //валидация данных куки
	{

		if (!$this->user_id || !$this->version || !$this->created) {  //существуют ли параметры из куки?
			throw new AuthException("Не правильные данные. Доступ запрещен");
		}

		if ($this->version != VERSION) {  //соотвествует ли версия куки?
			throw new AuthException("НЕ правильная версия файла кук");
		}

		if ((time() - $this->created) > EXPIRATION) { //если куки созданы раньше, чем EXPIRATION, выбрасываем юзера
			throw new AuthException("Закончилось время сессии");
		}
		if ((time() - $this->created) > WARNING_TIME) {
			$this->set();  // обновляем файл-куки
		}

		return TRUE;
	}

	public function logout()  //выход юзера из админки
	{
		setcookie(self::$cookie_name, "", (time() - 3600), SITE_URL);
		return TRUE;
	}

}