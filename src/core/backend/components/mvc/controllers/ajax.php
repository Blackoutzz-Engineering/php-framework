<?php
namespace core\backend\components\mvc\controllers;
use core\backend\components\mvc\controllers\rest;
use core\backend\mvc\controller\ajax\response;
use core\backend\mvc\controller\ajax\response_code;
use core\common\exception;
use core\common\conversions\json;
use core\program;

/**
 * Ajax API.
 *
 * @version 1.0
 * @author  Mickael Nadeau
 * @twitter @Mick4Secure
 * @github  @Blackoutzz
 * @website https://Blackoutzz.me
 **/

class ajax extends rest
{

    public function initialize()
    {
        header("Content-Type: text/json");
        try
        {
            if($this->has_view())
            {
                if($this->has_access())
                {
                    $value = $this->prepare_view();
                    if($value !== null)
                    {
                        $response = new response($value);
                        echo $response;
                    }
                    if(!$data = program::pull())
                    {
                        $this->on_null();
                    } else {
                        echo $data;
                    }
                    program::end(response_code::successful);
                } else {   
                    throw new exception("Invalid api path",response_code::access_denied);
                }
            } else {
                throw new exception("Invalid api path",response_code::invalid_call);
            }
        } 
        catch (exception $e)
        {
            switch($e->get_code())
            {
                case response_code::access_denied:
                    $this->on_access_denied($e);
                break;
                case response_code::invalid_call:
                    $this->on_invalid_call($e);
                break;
                case response_code::unexpected_error:
                    $this->on_unexpected_call_error($e);
                break;
                default:
                    $this->on_invalid_call($e);
            }
        }
            
    }

    protected function on_access_denied($pexception)
    {
        if($pexception instanceof exception)
        {
            if(program::is_running_dev_mode())
                $response = new response($pexception);
            else
                $response = new response($pexception->get_message());
        } else {
            $response = new response(null);
        }
        echo $response;
        program::end(response_code::access_denied);
    }

    protected function on_invalid_call($pexception)
    {
        if($pexception instanceof exception)
        {
            if(program::is_running_dev_mode())
                $response = new response($pexception);
            else
                $response = new response($pexception->get_message());
        } else {
            $response = new response(null);
        }
        echo $response;
        program::end(response_code::invalid_call);
    }

    protected function on_unexpected_call_error($pexception)
    {
        if($pexception instanceof exception)
        {
            if(program::is_running_dev_mode())
                $response = new response($pexception);
            else
                $response = new response($pexception->get_message());
        } else {
            $response = new response(null);
        }
        echo $response;
        program::end(response_code::unexpected_error);
    }

    protected function get_error($pcode,$pmsg)
    {
        return $this->on_error($pcode,$pmsg);
    }

    protected function add_error($pcode,$pmsg)
    {
        return $this->on_error($pcode,$pmsg);
    }

    protected function delete_error($pcode,$pmsg)
    {
        return $this->on_error($pcode,$pmsg);
    }

    protected function update_error($pcode,$pmsg)
    {
        return $this->on_error($pcode,$pmsg);
    }

    protected function on_null()
    {
        $response = new response(null);
        echo $response;
    }

    protected function on_error($pcode,$pmsg)
    {
        http_response_code(intval($pcode));
        return $pmsg;
    }



}
