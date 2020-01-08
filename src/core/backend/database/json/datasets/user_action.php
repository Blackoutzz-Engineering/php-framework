<?php
namespace core\backend\database\json\datasets;
use core\backend\database\dataset;
use core\backend\database\model;
use core\common\components\time\date;

class user_action extends dataset
{

    protected $user = NULL;

    protected $action = NULL;

    protected $ip = "0.0.0.0";

    protected $date;

    public  function __construct($pdata)
    {
        $this->table_name = "user_actions";
        $this->parse_data($pdata);
    }

    public  function __toString()
    {
        return $this->get_user()->get_name()." has ".$this->get_action()->get_name()." from ".$this->ip." ".$this->get_date()->get_elasped_time();
    }

    public  function get_user()
    {
        return model::get_user_by_id($this->user);
    }

    public  function set_user($puser)
    {
        if(model::is_user($puser))
        {
            $this->user = $puser->get_id();
            return true;
        }
        if($puser != NULL && is_integer($puser))
        {
            $new_user = model::get_user_by_id($puser);
            if($new_user != NULL && model::is_user($new_user))
            {
                $this->user = $new_user->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_action()
    {
        return model::get_action_by_id($this->action);
    }

    public  function set_action($paction)
    {
        if(model::is_action($paction)){
            $this->action = $paction->get_id();
            return true;
        }
        if($paction != NULL && is_integer($paction)){
            $new_action = model::get_action_by_id($paction);
            if($new_action != NULL && model::is_action($new_action)){
                $this->action = $new_action->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_ip()
    {
        return $this->ip;
    }

    public  function set_ip($pip)
    {
        $this->ip = $pip;
        return true;
    }

    public  function get_date()
    {
        return new date($this->date);
    }

    public  function set_date($pdate)
    {
        $this->date = date("l, j F Y",strtotime($pdate));
        return true;
    }

}
