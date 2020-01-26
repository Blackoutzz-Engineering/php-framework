<?php
namespace core\backend\components;
use core\common\str;
use core\program;

/**
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class log
{

    protected $folderpath;

    protected $name;

    public function __construct($pname="core")
    {
        $this->folderpath = program::$path."logs/";
        $this->name = $pname;
    }

    public function save($pdata)
    {
        $id = 0;
        if(isset(program::$users[0])) $id = program::$users[0]->get_id();
        $folder = $this->folderpath.$this->name.DS.date("Y").DS.date("F").DS;
        $log = $this->folderpath.$this->name.DS.date("Y").DS.date("F").DS.date("j").".log";
        if(!is_dir($folder)){
            if(!mkdir($folder,755,true)){
                if(program::is_running_dev_mode()) 
                    echo "log::get -> Permission denied to create log's folder.";
                else 
                    error_log("log::get -> Permission denied to create log's folder.");
                return false;
            }
        }
        if(!is_file($log))
        {
            if(file_put_contents($log,json_encode(array())) === false)
            {
                if(program::is_running_dev_mode()) 
                    echo "log::get -> Permission denied to create log's file.";
                else 
                    error_log("log::get -> Permission denied to create log's file.");
                die("Permission denied to create log's file.");
            }
        }
        $log_data = json_decode(file_get_contents($log),true);
        if(!is_array($log_data) || (is_array($log_data) && count($log_data) == 0))
        {
            $log_data = array();
            $log_data[runid] = array();
            $log_data[runid][] = $pdata;
        } else {

            $log_data[runid] = array();
            $log_data[runid][] = $pdata;
        }
        
        if(file_put_contents($log,json_encode($log_data)) === false)
        {
            if(program::is_running_dev_mode()) 
                echo "log::get -> Permission denied to create log's file.";
            else 
                error_log("log::get -> Permission denied to create log's file.");
            return false;
        }
        return true;
    }

    public function get_daily_logs()
    {
        $folder = $this->folderpath.$this->name.DS.date("Y").DS.date("F").DS;
        $log = $this->folderpath.$this->name.DS.date("Y").DS.date("F").DS.date("j").".log";
        if(!is_dir($folder)){
            if(!mkdir($folder,755,true)){
                error_log("log::get -> Permission denied to create log's folder.");
                return false;
            }
        }
        if(!is_file($log))
        {
            if(file_put_contents($log,json_encode(array())) === false){
                error_log("log::get -> Permission denied to create log's file.");
                die("Permission denied to create log's file.");
            }
        }
        return array_reverse(json_decode(file_get_contents($log),true));
    }

}