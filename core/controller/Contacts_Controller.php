<?php

/*
 * Класс вывода контактов
 */

class Contacts_Controller extends Base
{

    protected $contacts;

    protected function input($param = array())
    {
        parent::input();

        $this->title .= "Контакты";

        $this->contacts = $this->ob_m->get_contacts();

        $this->keywords = $this->contacts['keywords'];
        $this->keywords = $this->contacts['discription'];
    }

    protected function output()
    {

        $this->content = $this->render(VIEW . 'contacts_page', array(
            'contacts' => $this->contacts
        ));

        $this->page = parent::output();

        return $this->page;
    }

}