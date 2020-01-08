<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class controller extends dataset
{

    protected $name = "";

    public function save($pid = 0)
    {
        if($this->exist()){
            return $this->update_request("UPDATE `controllers` SET name=? WHERE id=?","si",array($this->name,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `controllers` (`name`) values (?)","s",array($this->name),$pid);
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
    
    public function get_views()
    {
        return $this->database()->get_model()->get_controller_views_by_controller($this);
    }

    public  function add_view($pview)
    {
        $view = NULL;
        if($pview instanceof view){
            $view = $pview;
        }
        if($view instanceof view){
            if(count($this->database()->get_model()->get_controller_view_by_controller_and_view($this,$view)) == 0){
                $new_controller_view = new controller_view(array("controller"=>$this->id,"view"=>$view->get_id()));
                return $new_controller_view->save();
            }
        }
        return false;
    }

    public  function remove_view($pview)
    {
        $cv = $this->database()->get_model()->get_controller_view_by_controller_and_view($this,$pview);
        if($this->database()->get_model()->is_user_controller_view($cv)){
            $cv->destroy();
        }
    }

}
