<?php
namespace core\backend\network\host;
use core\backend\database\dataset;

class host extends dataset
{

    protected $name;

    protected $address;

    public function is_alive() : bool
    {
        return true;
    }   

}