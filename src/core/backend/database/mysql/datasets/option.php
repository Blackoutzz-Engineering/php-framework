<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class option extends dataset
{

    protected $name = "";

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `options` SET name=? WHERE id=?","si",array($this->name,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `options` (`name`) VALUES (?)","s",array($this->name),$pid);
        }
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($pname)
    {
        $this->name = $this->get_sanitized_string($pname);
    }
    
}

