<?php

/*
 *Класс, который обрабатывает все ошибки, которые связаны с ошибками в контроллерах
 */

class ContrException extends Exception
{
	protected $message;  //свойство сообщения об ошибке

	public function __construct($text, $path = FALSE)
	{
		$this->message = $text;  //сообщение об ошибке, которое передаем при создании объекта класса

		$file = $this->getFile();  //имя файла, где хранится ошибка
		$line = $this->getLine();  //на какой строке файла произошла ошибка

		/*
		 *сохраняем имя файла с сообщением об ошибке и строку в сессию
		 */

		$_SESSION['error']['file'] = $file;
		$_SESSION['error']['line'] = $line;

		if ($path) {
			$_SESSION['error']['path'] = $path;
		}

		header("Location:".SITE_URL.'error/mes/'.rawurlencode($text));  //Перенаправляем на контроллер Error_Controller
	}
}