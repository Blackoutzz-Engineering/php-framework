<?php
namespace core\backend\database\json\datasets;
use core\backend\database\dataset;

class user_state extends dataset
{

    protected $name = "";

    public  function __construct($pdata)
    {
        $this->table_name = "user_states";
        $this->parse_data($pdata);
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
