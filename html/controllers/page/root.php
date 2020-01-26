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
        $this->send(["blacklist"=>["Menu","Dashboard"],"buttons"=>$this->databases->get_mysql_database_by_id()->get_model()->get_menu_buttons_by_user_and_group_and_granted($this->user->get_id(),$this->user->get_group())],"menu");
    }

    public function index()
    {
        $this->send(program::$users[0],"user");
        $this->send(program::$session,"session");
    }

    public function dashboard()
    {

    }

    public function login()
    {

    }

    public function forgot()
    {

    }

    public function register()
    {

    }

}
