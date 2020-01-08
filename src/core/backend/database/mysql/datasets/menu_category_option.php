<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class menu_category_option extends dataset
{

    protected $menu_category = NULL;

    protected $option = NULL;

    protected $value = "";
  
    public function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `menu_category_options` SET menu_button=?,option=?,value=? WHERE id=?","iisi",array($this->menu_category,$this->option,$this->value,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `menu_category_options` (`menu_category`,`option`,`value`) values (?,?,?)","iis",array($this->menu_category,$this->option,$this->value),$pid);
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
