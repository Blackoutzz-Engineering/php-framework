<?php
namespace core\common;
use core\backend\database\dataset;
use core\backend\components\filesystem\file;
use core\common\components\time\date;

class exception_log extends dataset
{

    protected $date;

    protected $user;

    protected $message;

    protected $file;

    protected $code;

    protected $line;

    protected $uri;

    public function __construct($pdata)
    {
        $this->date = $pdata["date"];
        $this->user = $pdata["user"];
        $this->file = $pdata["file"];
        $this->code = $pdata["code"];
        $this->line = $pdata["line"];
        $this->message = $pdata["msg"];
        $this->uri = $pdata["uri"];
    }

    public function get_user()
    {
        return $this->user;
    }

    public function get_date()
    {
        return new date($this->date);
    }

    public function get_message()
    {
        return $this->message;
    }

    public function get_file()
    {
        return new file($this->file);
    }

    public function get_code()
    {
        return $this->code;
    }

    public function get_line()
    {
        return $this->line;
    }

    public function get_uri()
    {
        return $this->uri;
    }

}