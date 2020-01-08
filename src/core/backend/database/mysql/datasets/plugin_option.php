<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;

class plugin_option extends dataset
{

    protected $plugin = NULL;

    protected $option = NULL;

    protected $value = "";

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `plugin_options` SET option=? , value=? WHERE id=? AND plugin=?","isii",array($this->option,$this->value,$this->id,$this->plugin),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `plugin_options` (`plugin`,`option`,`value`) VALUES (?,?,?)","iis",array($this->plugin,$this->option,$this->value),$pid);
        }
    }
    
}
