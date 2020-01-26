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

    protected $blacklist = [];

    public function __toHtml()
    {
        return [
            new hr(["class"=>"sidebar-divider my"]),
            new div(["class"=>"sidebar-heading"],"Dashboard"),
            $this->get_categories(),
            new hr(["class"=>"sidebar-divider my"])
        ];
    }

    protected function get_categories()
    {
        $buttons = [];
        $categories = [];
        $last_category ??= "";
        $menu_id = 0;
        foreach($this->buttons as $button)
        {
            $category = $button->get_category();
            $controller_view = $button->get_controller_view();
            if(in_array($category->get_name(),$this->blacklist)) continue;
            if($category->get_name() != $last_category)
            {
                if(count($buttons) >=1 )
                {
                    $categories[] = [
                        new li(["class"=>"nav-item"],[
                            new a(["class"=>"nav-link collapsed","href"=>"#","data-toggle"=>"collapse","data-target"=>"#collapseMenu".++$menu_id,"aria-expanded"=>"false", "aria-controls"=>"collapsePages"],[
                                new i(["class"=>"fas fa-fw fa-folder"]),
                                new span([],$last_category)
                            ]),
                            new div(["id"=>"collapseMenu".$menu_id,"class"=>"collapse","aria-labelledby"=>"headingPages","data-parent"=>"#accordionSidebar"],
                                new div(["class"=>"bg-white py-2 collapse-inner rounded"],$buttons)
                            )
                        ])
                    ];
                    $buttons = [];
                }
                $last_category = $category->get_name();
            } 
            $buttons[] = new a(["class"=>"collapse-item","href"=>"/{$controller_view}/"],$button);
        }
        if(count($buttons) >=1 )
        {
            $categories[] = [
                new li(["class"=>"nav-item"],[
                    new a(["class"=>"nav-link collapsed","href"=>"#","data-toggle"=>"collapse","data-target"=>"#collapseMenu".++$menu_id,"aria-expanded"=>"false", "aria-controls"=>"collapsePages"],[
                        new i(["class"=>"fas fa-fw fa-folder"]),
                        new span([],$last_category)
                    ]),
                    new div(["id"=>"collapseMenu".$menu_id,"class"=>"collapse","aria-labelledby"=>"headingPages","data-parent"=>"#accordionSidebar"],
                        new div(["class"=>"bg-white py-2 collapse-inner rounded"],$buttons)
                    )
                ])
            ];
        }
        return $categories;
    }

}
