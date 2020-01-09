<?php
namespace core\frontend\html\elements;
use core\frontend\html\void_element;

/**
 * HTML Element : input
 *
 * Based of the RE:DOM ideas
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class input extends void_element
{

    public function __construct($pattributes = array())
    {
        $this->tag = "input";
        $this->attributes = $pattributes;
    }

}
