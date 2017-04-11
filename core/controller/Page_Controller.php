<?php

/*
 * Класс вывода полного текста страниц (Новости,контакты и т.д.)
 */

class Page_Controller extends Base
{
    protected $page;  // свойство полного контента страницы

    protected function input($param)
    {
        parent::input();

        if (isset($param['id'])) {   //передан ли $id
            $id = $this->clear_int($param['id']);
            $this->page = $this->ob_m->get_page($id);
            $this->title .= $this->page['title'];
            $this->keywords = $this->page['keywords'];
            $this->discription = $this->page['discription'];

        }
    }

    protected function output()
    {
        $this->content = $this->render(VIEW . 'page_page', array(
            'page' => $this->page
        ));


        $this->page = parent::output();

        return $this->page;
    }
}