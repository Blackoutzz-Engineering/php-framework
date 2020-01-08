<?php
namespace controllers\ajax;
use core\backend\components\mvc\controllers\ajax;

class root extends ajax
{

    public function get_index()
    {
        return "Welcome";
    }

    public function get_test()
    {
        return "poggers!";
    }

    public function get_notest()
    {
        echo "poggers!";
    }

    public function get_nottest()
    {
        return false;
    }

}
