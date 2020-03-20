<?php
namespace core\backend\components\network;
use core\common\exception;
use core\backend\components\network\curl;
use core\backend\database\dataset;
use core\backend\network\curl\request_result;

/**
 * RPC API Component
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class rpc
{

    protected $url;

    protected $port;

    public function __construct($purl,$pport)
    {
        $this->url = $purl;
        $this->port = $pport;
    }

    protected function on_request_creation(&$request)
    {
        //override this to add feature to request.
        $request->set_header("Content-Type: binary/message-pack");
    }

    protected function send_get_request($ppath,$pheaders = array(),$pcookies = array())
    {
        try
        {
            $curl = new curl();
            $request = $curl->create_get_request("{$this->url}:{$this->port}".$ppath,$pheaders,$pcookies);
            $request->set_user_agent("Blackoutzz@web.framework - RPC/API");
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

    public function send_post_request($ppath,$pheaders = array(),$pcookies = array(),$pdata = array())
    {
        try
        {
            $curl = new curl();
            $request = $curl->create_post_request("{$this->url}:{$this->port}".$ppath,$pheaders,$pcookies,$pdata);
            $request->set_user_agent("Blackoutzz@web.framework - RPC/API");
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
