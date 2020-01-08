<?php
namespace core\backend\mvc\session;
use core\backend\database\dataset;

class status extends dataset
{

    protected $id;

    protected $name;

    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        switch($this->id)
        {
            case PHP_SESSION_ACTIVE:
                return "active";
            case PHP_SESSION_DISABLED:
                return "disabled";
            case PHP_SESSION_NONE:
                return "none";
            default:
                return "none";
        }
    }

    public function is_active()
    {
        return ($this->id === PHP_SESSION_ACTIVE);
    }

    public function is_disabled()
    {
        return ($this->id === PHP_SESSION_DISABLED);
    }

    public function is_none()
    {
        return ($this->id === PHP_SESSION_NONE);
    }

}