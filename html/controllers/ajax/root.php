<?php
namespace controllers\ajax;
use core\backend\components\mvc\controllers\ajax;

class root extends ajax
{

    public function get_index()
    {
        return "Welcome";
    }

    public function add_login()
    {
        if(isset($_REQUEST["email"]) && isset($_REQUEST["password"]))
        {
            $username = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            return $this->get_user()->login($username,$password);
        }
        return false;
    }

}
