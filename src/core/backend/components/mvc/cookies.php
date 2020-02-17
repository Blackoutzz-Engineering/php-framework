<?php
namespace core\backend\components\mvc;

/*
setcookie
setrawcookie
*/

class cookies 
{

    protected $array;

    public function get_cookies()
    {
        return $_COOKIE;
    }

}