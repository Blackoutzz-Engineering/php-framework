<?php 
namespace core\backend\mvc\user;
use core\backend\database\mysql\dataset_array;
use core\backend\database\mysql\datasets\user_group;

class groups extends dataset_array
{

    public function __construct($pdata = array())
    {
        $this->array[] = new user_group(["id"=>1,"name"=>"Banned"]);
        $this->array[] = new user_group(["id"=>2,"name"=>"Guest"]);
        $this->array[] = new user_group(["id"=>2,"name"=>"User"]);
        $this->array[] = new user_group(["id"=>2,"name"=>"Moderator"]);
        $this->array[] = new user_group(["id"=>2,"name"=>"Admin"]);
    }

}