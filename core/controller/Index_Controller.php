<?php

class Index_Controller extends Base
{
    public function __construct()
    {

    }

    protected function input()  //берет данные на вход,наследует от класса Base
    {
        parent::input();
        $this->title .= 'Главная';

    }

    protected function output()  //выдает данные на выход,наследует от класса Base
    {
        $this->header = $this->render(VIEW . 'header');
        $this->content = $this->render(VIEW. 'content');
        $this->page = parent::output();
        return $this->page;
    }
}