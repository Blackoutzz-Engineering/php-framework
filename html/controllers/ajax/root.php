<?php
namespace controllers\ajax;
use core\backend\components\mvc\controllers\ajax;

class root extends ajax
{

    public function get_index()
    {
        return "Welcome";
    }

}
