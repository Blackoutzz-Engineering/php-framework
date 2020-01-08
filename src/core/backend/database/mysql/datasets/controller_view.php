<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class controller_view extends dataset
{

    protected $controller = NULL;

    protected $view = NULL;

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `controller_views` SET controller=? , view=? WHERE id=?","iii",array($this->controller,$this->view,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `controller_views` (`controller`,`view`) VALUES (?,?)","ii",array($this->controller,$this->view),$pid);
        }
    }

    public  function get_controller()
    {
        return $this->database()->get_model()->get_controller_by_id($this->controller);
    }

    public  function set_controller($pcontroller)
    {
        if($this->database()->get_model()->is_controller($pcontroller)){
            $this->controller = $pcontroller->get_id();
            return true;
        }
        if($pcontroller != NULL && is_integer($pcontroller)){
            $new_controller = $this->database()->get_model()->get_controller_by_id($pcontroller);
            if($new_controller != NULL && $this->database()->get_model()->is_controller($new_controller)){
                $this->controller = $new_controller->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_view()
    {
        return $this->database()->get_model()->get_view_by_id($this->view);
    }

    public  function set_view($pview)
    {
        if($this->database()->get_model()->is_view($pview)){
            $this->view = $pview->get_id();
            return true;
        }
        if($pview != NULL && is_integer($pview)){
            $new_view = $this->database()->get_model()->get_controller_by_id($this->controller);
            if($new_view != NULL && $this->database()->get_model()->is_view($new_view)){
                $this->view = $new_view->get_id();
                return true;
            }
        }
        return false;
    }

    public  function __toString()
    {
        $controller = $this->get_controller();
        $view = $this->get_view();
        if($this->database()->get_model()->is_controller($controller) && $this->database()->get_model()->is_view($view))
        {
            if($controller != "root") return "{$controller}/{$view}";
            else return "{$view}";
        } else {
            return "install/index";
        }

    }

}

