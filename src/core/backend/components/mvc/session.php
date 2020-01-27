<?php
namespace core\backend\components\mvc;
use core\backend\mvc\session\status;
use core\backend\database\dataset_array;
use core\backend\database\dataset;
use core\backend\components\mvc\user;
use core\program;

class session extends dataset_array
{

    public function __construct()
    {
        $this->array = array();
        if($this->start())
        {
            $this->restore();
        }
    }

    public function __destruct()
    {
        if(session_status() == PHP_SESSION_ACTIVE)
            $this->save();
    }

    public function start()
    {
        switch(session_status())
        {
            case PHP_SESSION_ACTIVE:
                return true;
            case PHP_SESSION_DISABLED:
                return false;
            case PHP_SESSION_NONE:
                return session_start();
            default:
                return (session_status() == PHP_SESSION_ACTIVE);
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            if($value instanceof dataset_array || $value instanceof dataset)
                $this->array[] = $value->__serialize();
            else
                $this->array[] = $value;
        } else {
            if($value instanceof dataset_array || $value instanceof dataset)
                $this->array[$offset] = $value->__serialize();
            else
                $this->array[$offset] = $value;
        }
        $this->save();
    }

    protected function set_default_value()
    {
        $this->array = [];
        $this->save();
        return session_reset();
    }

    protected function save()
    {
        $_SESSION = $this->__toArray();
    }

    protected function restore()
    {
        $this->array = $_SESSION;
    }

    public function reset()
    {
        $this->set_default_value();
        return session_regenerate_id(true);
    }

    public function destroy()
    {
        return session_destroy();
    }

    public function has_user()
    {
        return (isset($this->array["user"]));
    }

    public function get_status() 
    {
        return new status(["id"=>session_status()]);
    }

}