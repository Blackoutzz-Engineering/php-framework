<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class app_options extends dataset
{

    protected $option;

    protected $value;

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `app_options` SET option=? , value=? WHERE id=?","isi",array($this->option,$this->value,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `app_options` (`option`,`value`) VALUES (?,?)","is",array($this->option,$this->value),$pid);
        }
    }

    public function get_option()
    {
        return $this->option;
    }

    public function get_value()
    {
        return $this->value;
    }
    
}
