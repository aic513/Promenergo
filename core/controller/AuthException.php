<?php

/*
 * Класс для обработки ошибок-исключений, связанных с авторизацией пользователя
 */

class AuthException extends Exception
{
	public function __construct($text)
	{
		$this->message = $text;
		$_SESSION['auth'] = $text;
	}
}