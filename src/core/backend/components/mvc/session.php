<?php
namespace core\backend\components\mvc;
use core\backend\mvc\session\status;
use core\backend\database\dataset_array;
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

    protected function set_default_value()
    {
        session_reset();
        $this->save();
    }

    protected function save()
    {
        $_SESSION = $this->__toArray();
    }

    protected function restore()
    {
        $this->array = $_SESSION;
        //if($this->has_user()) program::$users[0] = new user($this->array["user"]);
    }

    public function reset()
    {
        session_regenerate_id(true);
        $this->set_default_value();
    }

    public function destroy()
    {
        session_destroy();
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