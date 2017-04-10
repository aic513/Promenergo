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

    public function get_news()  //выбрать новости
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


}