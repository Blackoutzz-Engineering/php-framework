<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class user_option extends dataset
{

    protected $user = NULL;

    protected $option = NULL;

    protected $value = "";

    public  function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `user_options` SET user=? , `option`=? , value=? WHERE id=?","iisi",array($this->user,$this->option,(string)$this->value,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `user_options` (`user`,`option`,`value`) VALUES (?,?,?)","iis",array($this->user,$this->option,(string)$this->value),$pid);
        }
    }

    public function __toString()
    {
        return (string) $this->value;
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

    public  function get_user()
    {
        return $this->database()->get_model()->get_users_by_id($this->user);
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
            $new_user = $this->database()->get_model()->get_users_by_id($puser)[0];
            if($new_user != NULL && $this->database()->get_model()->is_user($new_user))
            {
                $this->user = $new_user->get_id();
                return true;
            }
        }
        return false;
    }

}
