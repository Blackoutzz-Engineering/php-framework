<?php
namespace core\frontend\html\elements;
use core\frontend\html\element;

/**
 * HTML Element : meter
 *
 * Based of the RE:DOM ideas
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class meter extends element
{

    public function __construct($pattributes = array(), $pinner_html = array())
    {
        $this->tag = "meter";
        $this->inner_html = $pinner_html;
        $this->attributes = $pattributes;
    }

}
