<?php

/*
 *Промежуточный класс между классами,которые выводят страницы на сайт и классом Base_Controller
 * Класс описывает методы,которые будут работать на всех страницах (Вывод шапки,вывод новостей,вывод каталога и т.д.)
 * Эти методы будут описываться только в этом классе,так как будут работать на всем сайте и описывать их в каждом классе ни к чему
 */

abstract class Base extends Base_Controller
{
    protected $ob_m;  // здесь будет создаваться и храниться объект для работы с моделью сайта (БД)
    protected $title; //свойство для заголовка каждой страницы
    protected $style; // свойство для путей к файлам стилей,например template/default/style.css
    protected $script; // аналогично выше,только для скриптов
    protected $header;  //здесь будет храниться шаблон шапки сайта с переданными в него переменными
    protected $header_menu;
    protected $content; //средняя контентная часть сайта
    protected $left_bar;//шаблон левого блока
    protected $right_bar;//шаблон правого блока
    protected $footer;
    protected $right_side = TRUE;  //так как правая область есть не на каждой странице,то с помощью FALSE будем ее скрывать
    protected $news;  //массив новостей
    protected $pages;  //информация в левом блоке сайта
    protected $catalog_type;  //тип каталога
    protected $catalog_brands;  //список брендов слева
    protected $keywords,$discription;

    protected function input()  //берет данные на вход
    {
        $this->title = "Промстрой энерго | ";

        foreach ($this->styles as $style) {
            $this->style[] = VIEW . $style;
        }

        foreach ($this->scripts as $script) {
            $this->script[] = VIEW . $script;
        }
        //Object Model
        $this->ob_m = Model::get_instance();    //создаем объект класса Model
        $this->news = $this->ob_m->get_news();  //получаем данные для блока с новостями справа
        $this->pages = $this->ob_m->get_pages(); //получаем данные для блока с новостями слева
        $this->catalog_type = $this->ob_m->get_catalog_type(); //получаем данные для блока тип каталога
        $this->catalog_brands = $this->ob_m->get_catalog_brands(); //получаем данные для блока тип каталога
        $this->header_menu = $this->ob_m->get_header_menu(); //получаем данные для блока меню в хедере (здоровые картинки)
        
    }


    
    protected function output()  //выдает данные на выход
    {
        $this->left_bar = $this->render(VIEW . 'left_bar',
            array('pages' => $this->pages,
                'types' => $this->catalog_type,
                'brands' => $this->catalog_brands)
        );
        if ($this->right_side) {
            $this->right_bar = $this->render(VIEW . 'right_bar',
                array('news' => $this->news));
        }

        $this->footer = $this->render(VIEW . 'footer',
            array('pages' => $this->pages));

        $this->header = $this->render(VIEW . 'header',
            array(
                'styles'=>$this->style,
                'scripts'=>$this->script,
                'header_menu'=>$this->header_menu,
                'title' => $this->title,
                'keywords'=>$this->keywords,
                'discription'=>$this->discription
            ));

        $page = $this->render(VIEW . 'index',
            array(
                'header' => $this->header,
                'left_bar' => $this->left_bar,
                'content' => $this->content,
                'right_bar' => $this->right_bar,
                'footer' => $this->footer
            )
        );
        return $page;
    }


}