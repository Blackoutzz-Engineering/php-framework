<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class user_controller_view extends dataset
{

    protected $user = NULL;

    protected $controller_view = NULL;

    protected $granted = 0;

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `user_controller_views` SET user=? , controller_view=? , granted=? WHERE id=?","iiii",array($this->user,$this->controller_view,$this->granted,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `user_controller_views` (`user`,`controller_view`,`granted`) VALUES (?,?,?)","iii",array($this->user,$this->controller_view,$this->granted),$pid);
        }
    }

    public  function get_user()
    {
        return $this->database()->get_model()->get_user_by_id($this->user);
    }

    public  function set_user($puser)
    {
        if($this->database()->get_model()->is_user($puser))
        {
            $this->user = $puser->get_id();
            return true;
        }
        if($puser != NULL && is_integer($puser))
        {
            $new_user = $this->database()->get_model()->get_user_by_id($puser);
            if($new_user != NULL && $this->database()->get_model()->is_user($new_user))
            {
                $this->user = $new_user->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_controller_view()
    {
        return $this->database()->get_model()->get_controller_view_by_id($this->controller_view);
    }

    public  function set_controller_view($pcontroller_view)
    {
        if($this->database()->get_model()->is_controller_view($pcontroller_view))
        {
            $this->controller_view = $pcontroller_view->get_id();
            return true;
        }
        if($pcontroller_view != NULL && is_integer($pcontroller_view))
        {
            $new_controller_view = $this->database()->get_model()->get_controller_by_id($pcontroller_view);
            if($new_controller_view != NULL && $this->database()->get_model()->is_controller_view($new_controller_view))
            {
                $this->controller_view = $new_controller_view->get_id();
                return true;
            }
        }
        return false;
    }

    public  function set_granted($pbool)
    {
        if($pbool >= 1 || $pbool === true)
        {
            $this->granted = 1;
            return true;
        }
        if($pbool <= 0 || $pbool === false)
        {
            $this->granted = 0;
            return true;
        }
        $this->granted = 0;
        return false;
    }

    public  function get_granted()
    {
        return ($this->granted >= 1 || $this->granted === true);
    }

}
