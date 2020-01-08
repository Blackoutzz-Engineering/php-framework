<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class user_group_option extends dataset
{

    protected $user_group = NULL;

    protected $option = NULL;

    protected $value = "";

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `user_group_options` SET user_group=? , option=? , value=? WHERE id=?","iisi",array($this->user_group,$this->option,$this->value,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `user_group_options` (`user_group`,`option`,`value`) VALUES (?,?,?)","iis",array($this->user_group,$this->option,$this->value),$pid);
        }
    }

    public  function get_user_group()
    {
        return $this->database()->get_model()->get_user_group_by_id($this->user_group);
    }

    public  function set_user_group($puser_group)
    {
        if(is_object($puser_group) && $this->database()->get_model()->is_user_group($puser_group))
        {
            $this->user_group = $puser_group->get_id();
            return true;
        }
        if($puser_group != NULL && is_integer($puser_group))
        {
            $new_user_group = $this->database()->get_model()->get_user_groups_by_id($puser_group)[0];
            if($new_user_group != NULL && $this->database()->get_model()->is_user_group($new_user_group))
            {
                $this->user_group = $new_user_group->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_option()
    {
        return $this->database()->get_model()->get_option_by_id($this->option);
    }

    public  function set_option($poption)
    {
        if($this->database()->get_model()->is_option($poption))
        {
            $this->option = $poption->get_id();
            return true;
        }
        if($poption != NULL && is_integer($poption))
        {
            $new_option = $this->database()->get_model()->get_option_by_id($poption);
            if($new_option != NULL && $this->database()->get_model()->is_option($new_option))
            {
                $this->option = $new_option->get_id();
                return true;
            }
        }
        return false;
    }

    public  function get_value()
    {
        return $this->value;
    }

    public  function set_value($pvalue)
    {
        $this->value = $pvalue;
    }

}
