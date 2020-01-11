<?php 
namespace core\backend\mvc\user;
use core\backend\database\mysql\dataset_array;
use core\backend\database\mysql\datasets\user_state;

class states extends dataset_array
{

    public function __construct($pdata = array())
    {
        $this->array[] = new user_state(["id"=>1,"name"=>"Disconnected"]);
        $this->array[] = new user_state(["id"=>2,"name"=>"Connected"]);
    }

}