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

    protected $curl;

    protected $url;

    protected $key;

    public function __construct($purl,$pkey = "secret")
    {
        $this->url = $purl;
        $this->key = $pkey;
        $this->curl = new curl();
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
            $request = $this->curl->create_get_request($this->url.$ppath,$pheaders,$pcookies);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                if($result->is_successful())
                {
                    $content_type = $result->get_header("content-type");
                    if($content_type === "application/json" || $content_type === "text/json")
                    {
                        return json_decode($result->get_body());
                    }
                    return $result->get_body();
                }
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
            $request = $this->curl->create_post_request($this->url.$ppath,$pheaders,$pcookies,$pdata);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                if($result->is_successful())
                {
                    $content_type = $result->get_header("content-type");
                    if($content_type === "application/json" || $content_type === "text/json")
                    {
                        return json_decode($result->get_body());
                    }
                    return $result->get_body();
                }
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
            $request = $this->curl->create_delete_request($this->url.$ppath,$pheaders,$pcookies);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                if($result->is_successful())
                {
                    $content_type = $result->get_header("content-type");
                    if($content_type === "application/json" || $content_type === "text/json")
                    {
                        return json_decode($result->get_body());
                    }
                    return $result->get_body();
                }
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
            $request = $this->curl->create_put_request($this->url.$ppath,$pheaders,$pcookies,$pdata);
            $request->set_user_agent("Blackoutzz@web.framework - API");
            $this->on_request_creation($request);
            $result = $request->send();
            if($result instanceof request_result)
            {
                if($result->is_successful())
                {
                    $content_type = $result->get_header("content-type");
                    if($content_type === "application/json" || $content_type === "text/json")
                    {
                        return json_decode($result->get_body());
                    }
                    return $result->get_body();
                }
            }
            throw new exception("Api request failed.");
        } catch (exception $e)
        {
            return false;
        }
        
    }

}