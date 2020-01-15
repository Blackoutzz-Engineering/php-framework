<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class user_group extends dataset
{

    protected $name = "";

    public function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `user_groups` SET name=? WHERE id=?","si",array($this->name,$this->id));
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `user_groups` (`name`) VALUES (?)","s",array($this->name),$pid);
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


    public  function get_permissions()
    {
        return $this->database()->get_model()->get_user_group_permissions_by_user_group($this);
    }

    public  function get_controller_views()
    {
        return $this->database()->get_model()->get_user_group_controller_views_by_user_group($this);
    }

    public function get_options()
    {
        return $this->database()->get_model()->get_user_group_options_by_user_group($this);
    }

}
