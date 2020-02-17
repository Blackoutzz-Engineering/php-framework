<?php
namespace controllers\page;
use core\backend\components\mvc\controllers\page;
use core\common\components\stack;
use core\backend\system\environment;
use core\program;

class root extends page
{

    public function on_initialize()
    {
        $category_blacklist = ["Dashboard"];
        if($this->user->is_authenticated()) 
        {
            $category_blacklist[] = "Menu";
        }
        $this->send(["blacklist" => $category_blacklist, "buttons" => $this->databases->get_mysql_database_by_id()->get_model()->get_menu_buttons_by_user_and_group_and_granted($this->user->get_id(), $this->user->get_group())], "menu");
    }

    public function index()
    {
        
    }

    public function dashboard()
    {
        if(!$this->user->is_authenticated()) $this->redirect("/");
    }

    public function login()
    {
        if($this->user->is_authenticated()) $this->redirect("/");
    }

    public function forgot()
    {

    }

    public function register()
    {

    }

}
