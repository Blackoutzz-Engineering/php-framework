<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class view extends dataset
{

    protected $name = "";

    public function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `views` SET name=? WHERE id=?","si",array($this->name,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `views` (`name`) VALUES (?)","s",array($this->name),$pid);
        }
    }

    public function __toString()
    {
        return $this->name;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($pname)
    {
        $this->name = $this->get_sanitized_string($pname);
    }

    protected function get_prefix()
    {
        switch(strtolower($_SERVER["REQUEST_METHOD"]))
        {
            case "get":
                return "get_";
            case "put": 
                return "update_";
            case "delete":
                return "delete_";
            case "post":
                return "add_";
            default:
                return "get_";
        }
    }

}
