<?php
namespace controllers\page;
use core\backend\components\mvc\controllers\page;
use core\common\components\stack;
use core\backend\system\environment;

class root extends page
{

    public function index(){}

    public function info(){}

    public function test()
    {
        $test = new stack(array("0"=>"up","192.168.1.1"=>"up","192.168.1.2"=>"up","192.168.1.3"=>"up","192.168.1.4"=>"up"));
        $this->send(environment::get_variable("ADMIN_USERNAME"),"test");
    }

}
