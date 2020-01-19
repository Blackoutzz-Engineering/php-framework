<?php
namespace core\backend\database\mysql;
use core\backend\database\dataset as database_dataset;
use core\common\exception;
use core\program;

/**
 * Dataset Array
 * 
 * @version 1.0
 * @author  Mickael Nadeau
 * @twitter @Mick4Secure
 * @github  @Blackoutzz
 * @website https://Blackoutzz.me
 **/

abstract class dataset extends database_dataset
{

    protected $id = 0;

    public function exist()
    {
        if($this->id !== NULL && $this->id !== false && $this->id >= 1)
        {
            return true;
        } else {
            return false;
        }
    }

    public function get_id()
    {
        return $this->id;
    }

    protected function set_id($pid = 0)
    {
        $this->id = intval($pid);
    }

    public function save($pid = 0)
    {

    }

    public function delete($pid = 0)
    {

    }

    public function __toString()
    {
        return $this->parse_table_name();
    }

    public function parse_table_name()
    {
        $table_name =explode('\\', get_class($this));
        return array_pop($table_name);
    }

    protected function database($pid = 0)
    {
        $id = intval($pid);
        return program::$databases->get_mysql_database_by_id($id);
    }

    protected function execute_prepared_select_query($pquery,$pparam_types = false,$pparams = false,$pid = 0)
    {
        return $this->database($pid)->get_connection()->get_prepared_select_query($pquery,$pparam_types,$pparams);
    }

    protected function execute_prepared_insert_query($pquery,$pparam_types = false,$pparams = false,$pid = 0)
    {
        if($result = $this->database($pid)->get_connection()->get_prepared_insert_query($pquery,$pparam_types,$pparams))
            $this->id = $this->database($pid)->get_connection()->get_last_id();
        return $result;
    }

    protected function execute_prepared_update_query($pquery,$pparam_types = false,$pparams = false,$pid = 0)
    {
        return $this->database($pid)->get_connection()->get_prepared_update_query($pquery,$pparam_types,$pparams);
    }


}
