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

    public function __construct()
    {
        try {
            $this->ins_driver = Model_Driver::get_instance();
        } catch (DbException $e) {
            exit();
        }
    }

    public function test_sql()//ля теста запроса
    {
        $result = $this->ins_driver->select( //обращаемся к объекту класса Model_Driver  и вызываем у него метод select()
            array("type_id", "type_name"),
            'type'
//            array('publish' => 1, "in_header" => 1),
//            "date",
//            "DESC",
//            10,
//            array("=", ">"),
//            array('title,text'=>'kran')
        );
        return $result;
    }

}