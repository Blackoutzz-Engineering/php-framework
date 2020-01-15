<?php
namespace core\frontend\components;
use core\backend\database\dataset;
use core\frontend\html\node;

/**
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class widget extends dataset
{

    protected function get_html($phtml)
    {
        $html = "\n";
        if(is_array($phtml))
        {
            foreach($phtml as $element)
            {
                if(is_array($element))
                {
                    $html .= $this->get_html_array($element);
                } 
                else
                {
                    $html .= $element."\n";
                }
                
            }
            return $html;
        } else {
            $html .= $this->inner_html."\n";
        }
        return $html;
    }

    protected function get_html_array($parray)
    {
        $html = "\n";
        if(is_array($parray))
        {
            foreach($parray as $element)
            {
                if(is_array($element))
                {
                    $html .= $this->get_html_array($element);
                } 
                else
                {
                    $html .= $element."\n";
                }
            }
        }
        return $html;
    }

    public function __toString()
    {
        $html = $this->__toHtml();
        if($html instanceof node)
            return (string) $html;
        else
            return $this->get_html($html);
    }

    public function __toHtml()
    {
        //override this to print
        return "<pre>".print_r($this->__toArray())."</pre>";
    }

}
