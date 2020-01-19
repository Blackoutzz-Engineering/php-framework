<?php
namespace core\backend\network\curl;
use core\backend\network\http\status_code;
use core\common\components\regex;
use core\backend\database\dataset_array;
use core\backend\database\dataset;
use core\common\components\stack;


/**
 * request_result short summary.
 *
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Email   blackoutzzshoot@gmail.com
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class request_result
{

    protected $code = 0;

    protected $headers = "";

    protected $body = "";

    protected $error = "";

    public function __construct($pcode,$pheaders,$pbody,$perror)
    {
        $this->parse_headers($pheaders);
        $this->body = $pbody;
        $this->code = $pcode;
        $this->error = $perror;
    }

    protected function parse_headers($pheaders)
    {
        $this->headers = new stack();
        foreach(explode("\n",$pheaders) as $header)
        {
            if(preg_match("~^\s*([^:]+)[:](.*)\s*$~m",$header,$array))
            {
                $this->headers[$array[1]] = $array[2]; 
            }
        }
    }

    public function __toString()
    {
        return $this->body;
    }

    public function get_headers()
    {
        return $this->headers;
    }

    public function get_header($pname)
    {
        if(isset($this->headers[$pname])) return $this->headers[$pname];
        return "";
    }

    public function get_code()
    {
        return $this->code;
    }

    public function get_error()
    {
        return $this->error;
    }

    public function get_body()
    {
        return $this->body;
    }

    public function is_received()
    {
        if($this->code != 0 && $this->body != false) return true;
        return false;
    }

    public function is_successful()
    {
        return status_code::is_successful($this->code);
    }

    public function is_redirected()
    {
        return status_code::is_redirected($this->code);
    }

    public function is_failed()
    {
        return status_code::is_failed($this->code);
    }

    public function is_crashed()
    {
        return status_code::is_crashed($this->code);
    }

    public function is_blocked()
    {
        return status_code::is_blocked($this->code);
    }

    public function is_cloudproxy_blocked()
    {
        return status_code::is_cloudproxy_blocked($this->code);
    }

    public function get_cloudproxy_block_id()
    {
        try{
            if($this->body === "" || !$this->code || $this->code == 0) throw new exception("NULL Request result");
            if($this->code === status_code::internal_server_error) return "NONE";
            if($this->code === status_code::forbidden) 
            {
                $block = new regex("X-Sucuri-Block: +([A-z0-9]+) *");
                if($block->match($this->headers))
                {
                    return $block->get_match($this->headers)[1];
                }
            }
            return "NONE";
        }
        catch (Exception $e) 
        {
            return "NONE";
        }
    }

    public function is_cloudflare_blocked()
    {
        return status_code::is_cloudflare_blocked($this->code);
    }

}