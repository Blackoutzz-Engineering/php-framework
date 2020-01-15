<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class menu_category extends dataset
{

    protected $name = "";

    public function __toString()
    {
        return $this->name;
    }

    public function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `menu_categories` SET name=? WHERE id=?","si",array($this->name,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `menu_categories` (`name`) values (?)","s",array($this->name),$pid);
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
