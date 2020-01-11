<?php
namespace core\backend\components\mvc;
use core\backend\database\dataset;
use core\backend\database\mysql\model;
use core\backend\database\mysql\datasets\user_action;
use core\backend\database\mysql\datasets\user_state;
use core\backend\database\mysql\datasets\user_group;
use core\frontend\components\csrf;
use core\common\components\regex;
use core\common\regex as static_regex;
use core\common\str;
use core\common\exception;
use core\program;

/**
 * App User
 *
 * Default user of the application.
 *
 * @version 1.0
 * @author  Mickael Nadeau
 * @twitter @Mick4Secure
 * @github  @Blackoutzz
 * @website https://Blackoutzz.me
 **/

class user extends dataset
{

    protected $id = 0;

    protected $name = "Guest"; 

    protected $password;

    protected $email;

    protected $group;

    protected $state;

    protected $nonce;

    protected $authenticated;

    public function __construct()
    {
        $this->authenticated = false;
		if(isset($_SESSION["user"])) $this->restore();
	}

    public function get_user_agent()
    {
        try
        {
            if(isset($_SERVER))
            {
                if(isset($_SERVER["HTTP_USER_AGENT"]))
                {
                    return str::sanitize($_SERVER["HTTP_USER_AGENT"]);
                }
            }
            return false;
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    public function get_ip()
    {
        try
        {
            if(isset($_SERVER))
            {
                $ip = "0.0.0.0";
                $ipv4_regex = new regex(static_regex::ipv4);
                $ipv6_regex = new regex(static_regex::ipv6);
                if(isset($_SERVER["HTTP_X_SUCURI_CLIENTIP"])){
                    if(static_regex::is_ip($_SERVER["HTTP_X_SUCURI_CLIENTIP"])) return $ip;
                }
                if(isset($_SERVER["HTTP_X_REAL_IP"])){
                    if(static_regex::is_ip($_SERVER["HTTP_X_REAL_IP"])) return $ip;
                }
                if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    if(static_regex::is_ip($_SERVER["HTTP_X_FORWARDED_FOR"])) return $ip;
                }
                if(isset($_SERVER["REMOTE_ADDR"])){
                    $ip = $_SERVER["REMOTE_ADDR"];
                    if($ipv4_regex->match($ip) || $ipv6_regex->match($ip)) return $ip;
                }
                throw new exception("Invalid IP received from client");
            }
            throw new exception("No IP received from client");
        } 
        catch (exception $e)
        {
            return "0.0.0.0";
        }
    }

    public static function get_location()
    {
        return "Unknown";
    }

    public static function get_currency()
    {
        return "Unknown";
    }

	public function is_connected()
    {
        return ($this->authenticated === true);
	}

    public function is_banned()
    {
        return ($this->state->get_name() === "Banned");
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_password()
    {
        return $this->password;
    }

	public function get_group()
    {
        return $this->group;
    }

    public function get_nonce()
    {
        return $this->nonce;
    }

    public function get_id()
    {
        return $this->id;
    }

}
