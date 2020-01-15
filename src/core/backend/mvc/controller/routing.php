<?php 
namespace core\backend\mvc\controller;
use core\program;

class routing 
{

    public function exist() : bool
    {
        return (bool)(isset(program::$routing));
    }
    
    public function is_managed() : bool
    {
        return (bool)(program::$routing->is_managed());
    }

    public function is_unmanaged() : bool
    {
        return (bool)(program::$routing->is_unmanaged());
    }

    public function get_controller()
    {
        return program::$routing->get_controller();
    } 

    public function get_contoller_name()
    {
        return program::$routing->get_controller()->get_name();
    }

    public function get_controller_id()
    {
        return program::$routing->get_controller()->get_id();
    }

    public function get_view()
    {
        return program::$routing->get_view();
    }

    public function get_view_name()
    {
        return program::$routing->get_view()->get_name();
    }

    public function get_view_id()
    {
        return program::$routing->get_view()->get_id();
    }

    public function get_controller_view()
    {
        return program::$routing->controller_view;
    }

    public function get_parameters()
    {
        return program::$routing->get_parameters();
    }

}