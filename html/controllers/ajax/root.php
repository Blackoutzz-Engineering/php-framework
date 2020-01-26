<?php
namespace controllers\ajax;
use core\backend\components\mvc\controllers\ajax;

class root extends ajax
{
    
    public function add_login()
    {
        if(isset($_REQUEST["email"]) && isset($_REQUEST["password"]))
        {
            $username = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            return $this->user->login($username,$password);
        }
        return false;
    }

    public function get_test()
    {
        return null;
    }

}
