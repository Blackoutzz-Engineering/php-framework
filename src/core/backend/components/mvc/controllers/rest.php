<?php
namespace core\backend\components\mvc\controllers;
use core\backend\components\mvc\controller;
use core\common\exception;

class rest extends controller
{

    protected function prepare_view()
    {
        try
        {
            $no_parameter = 0;
            $view_name = $this->get_view_prefix().str_replace("-","_",$this->routing->get_view_name());
            $ref = new \ReflectionMethod($this,$view_name);
            $view_parameters = $this->routing->get_parameters();
            $count_view_parameters = count($view_parameters);
            $count_needed_parameters = count($ref->getParameters());
            //If No parameters are needed they will be ignored
            if($count_view_parameters === $no_parameter
            && $count_needed_parameters === $no_parameter)
            {
                return call_user_func(array($this,$view_name));
            }
            //If Parameters match perfectly
            if($count_view_parameters === $count_needed_parameters)
            {
                return call_user_func_array(array($this,$view_name),$view_parameters);
            }
            //View will be loaded with the first parameter provided
            if($count_view_parameters > $count_needed_parameters)
            {
                $params = array();
                for($i=0; $i > $count_needed_parameters; $i++)
                {
                    $params[] = $view_parameters[$i];

                }
                return call_user_func_array(array($this,$view_name),$params);

            }
            //View will be loaded with the first parameter provided and add false to the rest
            if($count_view_parameters < $count_needed_parameters)
            {
                $params = array();
                foreach($view_parameters as $param)
                {
                    $params[] = $param;
                }
                for($i=count($params);$i < $count_needed_parameters;$i++)
                {
                    $params[] = false;
                }
                return call_user_func_array(array($this,$view_name),$params);
            }
            //Missing or Invalid Parameters
            throw new exception("Invalid parameters.");
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    protected function has_view()
    {
        try
        {
            $prefix = $this->get_view_prefix();
            $view = $prefix.trim(strtolower(str_replace("-","_",$this->routing->get_view_name())));
            if(preg_match('~^([A-z]+[A-z-_]*[A-z]+)$~im',$view))
            {
                if(method_exists('core\\backend\\components\\mvc\\controllers\\api',$view)) 
                    throw new exception("Reserved view name");
                if(method_exists($this,$view))
                {
                    return true;
                } else {
                    throw new exception("No view configured inside controller");
                }
            } else {
                throw new exception("Invalid view name");
            }
        }
        catch (exception $e)
        {
            return false;
        }
    }

    protected function require_authentication()
    {
        try
        {
            if(isset($_REQUEST["key"]))
            {
                $api_key = $_REQUEST["key"];
                $user_option = model::get_user_option_by_option_and_value("api-key",$api_key);
                if(model::is_user_option($user_option))
                {
                    if($user_option->get_value() === $api_key)
                    {
                        $this->connected = true;
                        return true;
                    }
                }
                throw new exception("API: Invalid API Key.");
            } else {
                throw new exception("API: No key found.");
            }
        }
        catch(exception $e)
        {
            $this->on_requirement_failed();
            return false;
        }
    }

    protected function get_view_prefix()
    {
        switch(strtolower($_SERVER["REQUEST_METHOD"]))
        {
            case "get":
                return "get_";
            case "put": 
                return "update_";
            case "delete":
                return "delete_";
            case "post":
                return "add_";
            default:
                return "get_";
        }
    }

}
