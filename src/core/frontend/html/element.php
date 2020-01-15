<?php
namespace core\frontend\html;
use core\common\str;

/**
 * HTML Element
 *
 * Based of the RE:DOM ideas
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

abstract class element extends node
{
    
    protected $tag;

    protected $attributes = array();

    protected $inner_html = array();

    public function __construct($ptag , $pattributes = array(), $pinner_html = array())
    {
        $this->tag = $ptag;
        $this->parse_attributes($pattributes);
        $this->inner_html = $pinner_html;
    }

    public function get_inner_html()
    {
        $html = "\n";
        if(is_array($this->inner_html))
        {
            foreach($this->inner_html as $element)
            {
                if(is_array($element))
                {
                    $html .= $this->get_inner_html_array($element);
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

    protected function get_inner_html_array($parray)
    {
        $html = "\n";
        if(is_array($parray))
        {
            foreach($parray as $element)
            {
                if(is_array($element))
                {
                    $html .= $this->get_inner_html_array($element);
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
        if(count($this->attributes) >= 1)
        {
            return "<{$this->tag}".$this->get_attributes_text().">".$this->get_inner_html()."</{$this->tag}>";
        } else {
            return "<{$this->tag}>".$this->get_inner_html()."</{$this->tag}>";
        }
    }

}
