<?php
namespace core\backend\components\network;
use core\common\exception;
use core\backend\components\network\curl;
use core\backend\database\dataset;
use core\backend\network\curl\request_result;

/**
 * REST API Component
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class api extends curl
{

    protected $url;

    protected $key;

    public function __construct()
    {
        //Override this to add your key and url
    }

    protected function on_request_creation(&$request)
    {
        //override this to add feature to request.
    }

    //Get
    protected function send_get_request($ppath,$pheaders = array(),$pcookies = array())
    {
        try
        {
            $request = $this->create_get_request($this->url.$ppath,$pheaders,$pcookies);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                return $result;
            }
            throw new exception("Api request failed.");
        } catch (exception $e)
        {
            return false;
        }
        
    }

    //Add
    protected function send_post_request($ppath,$pheaders = array(),$pcookies = array(),$pdata = array())
    {
        try
        {
            $request = $this->create_post_request($this->url.$ppath,$pheaders,$pcookies,$pdata);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                return $result;
            }
            throw new exception("Api request failed.");
        } catch (exception $e)
        {
            return false;
        }
        
    }

    //Delete
    protected function send_delete_request($ppath,$pheaders = array(),$pcookies = array())
    {
        try
        {
            $request = $this->create_delete_request($this->url.$ppath,$pheaders,$pcookies);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                return $result;
            }
            throw new exception("Api request failed.");
        } catch (exception $e)
        {
            return false;
        }
        
    }

    //Update
    protected function send_put_request($ppath,$pheaders = array(),$pcookies = array(),$pdata = array())
    {
        try
        {
            $request = $this->create_put_request($this->url.$ppath,$pheaders,$pcookies,$pdata);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                return $result;
            }
            throw new exception("Api request failed.");
        } catch (exception $e)
        {
            return false;
        }
        
    }

}