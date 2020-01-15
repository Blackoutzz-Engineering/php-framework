<?php
namespace core\frontend\components\widgets;
use core\frontend\components\widget;
use core\frontend\html\elements\hr;
use core\frontend\html\elements\li;
use core\frontend\html\elements\a;
use core\frontend\html\elements\i;
use core\frontend\html\elements\span;
use core\frontend\html\elements\div;

/**
 * menu short summary.
 *
 * menu description.
 *
 * @Version 1.0
 * @Author  mick@blackoutzz.me
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class menu extends widget
{

    protected $buttons;

    public function __toHtml()
    {
        return [
            new hr(["class"=>"sidebar-divider my"]),
            new div(["class"=>"sidebar-heading"],"Menu"),
            $this->get_buttons()
        ];
    }

    protected function get_buttons()
    {
        $buttons = [];
        foreach($this->buttons as $button)
        {
            $category = $button->get_category();
            $last_category ??= $category->get_name();
            $controller_view = $button->get_controller_view();
            if($category->get_name() != $last_category)
            {
                $buttons[] = [
                    new hr(["class"=>"sidebar-divider my"]),
                    new div(["class"=>"sidebar-heading"],$category->get_name())
                ];
                $last_category = $category->get_name();
            }
            $buttons[] = new li(["class"=>"nav-item"],[
                new a(["class"=>"nav-link","href"=>"/{$controller_view}/"],[
                    new span([],$button)
                ])
            ]);
        }
        return $buttons;
    }

}
