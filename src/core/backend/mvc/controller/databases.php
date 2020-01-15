<?php
namespace core\backend\mvc\controller;
use core\program;

class databases 
{

    public function get_mysql_database_by_id($pid = 0)
    {
        $id = intval($pid);
        return program::$databases->get_mysql_database_by_id($id);
    }

}