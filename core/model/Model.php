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

    public function get_news()  //выбрать новости, выводит новости в правой колонке
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

    public function get_pages($all = FALSE)  //выводит контент в левой колонке
    {
        if ($all) {
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

    public function get_catalog_type()  //выводит типы каталога
    {
        $result = $this->ins_driver->select(
            array('type_id', 'type_name'),
            'type'
        );
        return $result;
    }

    public function get_catalog_brands()  //выводит товар по брендам слева
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


}