<?php
namespace core\common\components;
use core\common\str as static_str;

/**
 * str short summary.
 *
 * str description.
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class str 
{

    protected $string;

    public function __construct($pstring)
    {
        $this->string = (string) $pstring;
    }

    public function __toString()
    {
        return $this->string;
    }

    public function get_length()
    {
        return static_str::get_length($this->string);
    }

    public function remove($premove)
    {
        $this->string = static_str::remove($this->string,$premove);
        return $this->string;
    }

    public function replace($preplace,$preplaced = " ")
    {
        $this->string = static_str::replace($this->string,$preplace,$preplaced);
        return $this->string;
    }

    public function is_sanitized()
    {
        return static_str::is_sanitized($this->string);
    }

    public function sanitize()
    {
        return static_str::sanitize($this->string);
    }

    public function contains($pvalue,$pstrict = false)
    {
        return static_str::contains($this->string,$pvalue,$pstrict);
    }

    public function get_lines()
    {
        return static_str::get_lines($this->string);
    }

    public function get_line_by_id($pid)
    {
        return static_str::get_line_by_id($this->string,$pid);
    }

    public function get_compress()
    {
        return static_str::compress($this->string);
    }

    public function compress()
    {
        $this->string = static_str::compress($this->string);
        return $this->string;
    }

    public function get_uncompress()
    {
        return static_str::uncompress($this->string);
    }

    public function uncompress()
    {
        $this->string = static_str::uncompress($this->string);
        return $this->string;
    }

    public function output($pjson = false)
    {
        static_str::output($this->string,$pjson);
    }

    public function write($psanitize = true)
    {
        static_str::write($this->string,$psanitize);
    }

    public function writeline($psanitize = true)
    {
        static_str::writeline($this->string,$psanitize);
    }

    public function get_base64()
    {
        return static_str::get_base64($this->string);
    }

    public function get_contents()
    {
        return $this->string;
    }

    public function get_utf8()
    {
        return static_str::get_utf8($this->string);
    }

    public function get_bool()
    {
        if($this->string) return true;
        return false;
    }

    public function get_int()
    {
        return intval($this->string);
    }

    public function get_md5()
    {
        return md5($this->string);
    }

    public function get_hex($pdelimiter = false)
    {
        return static_str::get_hex($this->string,$pdelimiter);
    }

    public function convert_to_utf8()
    {
        $this->static_str::get_utf8($this->string);
    }

    public function convert_to_base64()
    {
        $this->string = static_str::get_base64($this->string);
    }

    public function convert_to_hex($pdelimter = false)
    {
        $this->string = static_str::get_hex($this->string,$pdelimter);
    }

}
