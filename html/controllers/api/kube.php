<?php
namespace controllers\api;
use core\backend\components\mvc\controllers\api;

class kube extends api
{
    
    public function get_ready()
    {
        return true;
    }

    public function get_live()
    {
        return true;
    }

}
