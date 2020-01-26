<?php
namespace core\common;
use core\program;
use core\backend\database\mysql\model;
use core\backend\components\log;
use core\common\str;
use core\common\time\sdate;
use core\common\components\time\date;
use core\backend\components\filesystem\file;

/**
 * App - Basic Exception Handler
 *
 * This exception handler is making sure to log everything related to any malfunction inside the app.
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class exception extends \Exception
{

    protected $log;

    protected $date;

    static $exceptions = array();

    public function __construct($message = "", $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct(str::sanitize($message),$code,$previous);
        self::$exceptions[] = $this;
        $this->date = time();
        $this->log = new log("exceptions");
        $this->save();
    }

    protected function save()
    {
        $id=0;
        if(isset(program::$users[0]))
        {
            $id = program::$users[0]->get_id();
        }
        $exception_log = array(
            "date"=>$this->date,
            "user"=>$id,
            "msg"=>$this->message,
            "file"=>$this->file,
            "code"=>$this->code,
            "line"=>$this->line,
            "uri"=>$_SERVER["REQUEST_URI"]
        );
        $this->log->save($exception_log);
    }

    public function get_code()
    {
        return $this->getCode();
    }

    public function get_message()
    {
        return $this->getMessage();
    }

    public function get_file()
    {
        return $this->getFile();
    }

    public function get_line()
    {
        return $this->getLine;
    }

    public function get_date()
    {
        return new date($this->date);
    }

    static function get_exceptions()
    {
        return self::$exceptions;
    }

}
