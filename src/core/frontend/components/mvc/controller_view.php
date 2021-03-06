<?php
namespace core\frontend\components\mvc;
use core\frontend\components\template;
use core\backend\components\file;
use core\frontend\components\widget;
use core\backend\mvc\controller\routing;
use core\frontend\html\element;
use core\common\exception;
use core\program;

/**
 * Controller view 
 *
 * Frontend display of the backend
 *
 * @Version 1.0
 * @Author  Mickael Nadeau
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/

class controller_view extends template
{

    protected $reference;

    protected $view_data;

    protected $cache;

    protected $routing;

    public function __construct($preference,$pcache,$pview_data)
    {
        $this->reference = $preference;
        $this->view_data = $pview_data;
        $this->routing = new routing();
        $this->cache = $pcache;
    }

    protected function get_user()
    {
        if(isset(program::$users[0]))
        {
            return program::$users[0];
        }
        return false;
    }

    protected function get_session()
    {
        if(isset(program::$session))
        {
            return program::$session;
        }
        return false;
    }

    protected function get_data($pname = false)
    {
        try
        {
            if($pname === false)
            {
                return $this->view_data;
            } else {
                foreach($this->view_data as $key => $data)
                {
                    if($key === $pname)
                    {
                        return $data;
                    }
                }
                throw new exception("No data named {$pname} found.");
            }
        } 
        catch (exception $e) 
        {
            return false;
        }
    }

    protected function get_html_element($pelement,$pattribute = array(),$pinner_html = array())
    {
        $element = (string) $pelement;
        if(preg_match("~^[a-z\\\_]+$~im",$element))
        {
            $element_class = "core\\frontend\\html\\elements\\{$element}";
            if(class_exists($element_class))
            {
                if(is_subclass_of($element_class,"core\\frontend\\html\\element",true))
                {
                    return new $element_class($pattribute,$pinner_html);
                }
                elseif(is_subclass_of($element_class,"core\\frontend\\html\\void_element",true))
                {
                    return new $element_class($pattribute);
                }
            }
        }
        return "";
    }

    protected function get_widget($pwidget,$pdata = array())
    {
        $widget = (string) $pwidget;
        if(preg_match("~^[a-z\\\_]+$~im",$widget))
        {
            $widget_class = "core\\frontend\\components\\widgets\\{$widget}";
            if(class_exists($widget_class))
            {
                $widget_instance = new $widget_class($pdata);
                if($widget_instance instanceof widget) 
                    return $widget_instance;
            }
        }
        return "";
    }

    public function load_layout()
    {
        try
        {
            $layout = "dashboard";
            if(!include(program::$path."ui".DS."themes".DS.$layout.DS."index.php"))
            {
                throw new exception("Impossible to load application theme named '{$layout}'.");
            }
            return true;
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    protected function load_script($name="")
    {
        try
        {
            $controller_name = $this->routing->get_contoller_name();
            $view_name = $this->routing->get_view_name();
            if($this->reference === "core")
            {
                if($name)
                {
                    if(is_file("assets".DS."scripts".DS."{$name}.min.js"))
                    {
                        echo ("<script src='/assets/scripts/{$name}.min.js'></script>");
                    } 
                    elseif(is_file("assets".DS."scripts".DS."{$name}.js"))
                    {
                        echo ("<script src='/assets/scripts/{$name}.js'></script>");
                    } else {
                        return false;
                    }
                    if(is_file("assets".DS."scripts".DS."{$name}.js.map"))
                    {
                        echo ("<script src='/assets/scripts/{$name}.js.map'></script>");
                    }
                    if(is_file("assets".DS."scripts".DS."{$name}.vendors.js"))
                    {
                        echo ("<script src='/assets/scripts/{$name}.vendors.js'></script>");
                    }
                } else {
                    if(is_file("assets".DS."scripts".DS.$controller_name.DS.$view_name.".min.js"))
                    {
                        echo ("<script src='/assets/scripts/{$controller_name}/{$view_name}.min.js'></script>");
                    } 
                    elseif(is_file("assets".DS."scripts".DS.$controller_name.DS.$view_name.".js"))
                    {
                        echo ("<script src='/assets/scripts/{$controller_name}/{$view_name}.js'></script>");
                    } else {
                        return false;
                    }
                    if(is_file("assets".DS."scripts".DS.$controller_name.DS.$view_name.".js.map"))
                    {
                        echo ("<script src='/assets/scripts/{$controller_name}/{$view_name}.js.map'></script>");
                    }
                    if(is_file("assets".DS."scripts".DS.$controller_name.DS.$view_name.".vendors.js"))
                    {
                        echo ("<script src='/assets/scripts/{$controller_name}/{$view_name}.vendors.js'></script>");
                    }
                }
                return true;
            } else {
                if($name)
                {
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS."{$name}.min.js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$name}.min.js'></script>");
                    }
                    elseif(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS."{$name}.js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$name}.js'></script>");
                    } else {
                        return false;
                    }
                    if(is_file("plugins/{$this->reference}/assets".DS."scripts".DS."{$name}.js.map"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$name}.js.map'></script>");
                    }
                    if(is_file("plugins/{$this->reference}/assets".DS."scripts".DS."{$name}.vendors.js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$name}.vendors.js'></script>");
                    }
                } else {
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS.$controller_name.DS.$view_name.".min.js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/".$controller_name."/".$view_name.".js'></script>");
                    }
                    elseif(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS.$controller_name.DS.$view_name.".js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/".$controller_name."/".$view_name.".js'></script>");
                    } else {
                        return false;
                    }
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS.$controller_name.DS.$view_name.".js.map"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$controller_name}/{$view_name}.js.map'></script>");
                    }
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."scripts".DS.$controller_name.DS.$view_name.".vendors.js"))
                    {
                        echo ("<script src='/plugins/{$this->reference}/assets/scripts/{$controller_name}/{$view_name}.vendors.js'></script>");
                    }
                }
                return true;
            }
        }
        catch (exception $e)
        {
            return false;
        }
    }

    protected function load_style($name="")
    {
        try
        {
            $controller_name = $this->routing->get_contoller_name();
            $view_name = $this->routing->get_view_name();
            if($this->reference === "core")
            {
                if($name)
                {
                    if(is_file("assets".DS."styles".DS."{$name}.min.css"))
                    {
                        echo ("<link href='/assets/styles/{$name}.min.css' rel=preload as=style />");
                        echo ("<link href='/assets/styles/{$name}.min.css' rel=stylesheet />");
                    } 
                    elseif(is_file("assets".DS."styles".DS."{$name}.css"))
                    {
                        echo ("<link href='/assets/styles/{$name}.css' rel=preload as=style />");
                        echo ("<link href='/assets/styles/{$name}.css' rel=stylesheet />");
                    } else {
                        return false;
                    }
                } else {
                    if(is_file("assets".DS."styles".DS.$controller_name.DS.$view_name.".min.css"))
                    {
                        echo ("<link href='/assets/styles/".$controller_name."/".$view_name.".min.css' rel=preload as=style />");
                        echo ("<link href='/assets/styles/".$controller_name."/".$view_name.".min.css' rel=stylesheet />");
                    } 
                    elseif(is_file("assets".DS."styles".DS.$controller_name.DS.$view_name.".css"))
                    {
                        echo ("<link href='/assets/styles/".$controller_name."/".$view_name.".css' rel=preload as=style />");
                        echo ("<link href='/assets/styles/".$controller_name."/".$view_name.".css' rel=stylesheet />");
                    } else {
                        return false;
                    }
                }
                return true;
            } else {
                
                if($name)
                {
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."styles".DS.$controller_name.DS.$view_name.".min.css"))
                    {
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/{$name}.min.css' rel=preload as=style />");
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/{$name}.min.css' rel=stylesheet />");
                    } 
                    elseif(is_file("plugins".DS.$this->reference.DS."assets".DS."styles".DS.$controller_name.DS.$view_name.".css"))
                    {
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/{$name}.css' rel=preload as=style />");
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/{$name}.css' rel=stylesheet />");
                    } else {
                        return false;
                    }
                } else {
                    if(is_file("plugins".DS.$this->reference.DS."assets".DS."styles".DS.$controller_name.DS.$view_name.".min.css"))
                    {
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/".$controller_name."/".$view_name.".min.css' rel=preload as=style />");
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/".$controller_name."/".$view_name.".min.css' rel=stylesheet />");
                    } elseif(is_file("plugins".DS.$this->reference.DS."assets".DS."styles".DS.$controller_name.DS.$view_name.".css")) {
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/".$controller_name."/".$view_name.".css' rel=preload as=style />");
                        echo ("<link href='/plugins/{$this->reference}/assets/styles/".$controller_name."/".$view_name.".css' rel=stylesheet />");
                    } else {
                        return false;
                    }
                }
                
                return true;
            }
        }
        catch (exception $e)
        {
            return false;
        }
    }

    public function load_view()
    {
        try
        {
            $controller_name = $this->get_controller_name();
            $view_name = $this->get_view_name();
            if($this->reference === "core")
            {
                if(!include(program::$path."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                {
                    $new_view = new file(program::$path."ui".DS."views".DS.$controller_name.DS.$view_name.".php");
                    $new_view->set_contents("<div class='alert alert-warning'>Brand new page without content.</div>");
                    if(!include(program::$path."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                       throw new exception("Impossible to load view on '{$controller_name}/{$view_name}'.");
                }
                $this->load_script();
                return true;
            } else {
                if(!$this->cache->is_saved() || !$this->cache->is_required())
                {
                    $this->push();
                    if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                    {
                        $new_view = new file(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php");
                        $new_view->set_contents("<div class='alert alert-warning'>Brand new page without content.</div>");
                        if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                            throw new exception("Impossible to load view on '{$controller_name}/{$view_name}'.");
                    }
                    $this->load_script();
                    if(!$this->cache->is_saved() && $this->cache->is_required())
                    {
                        $this->cache->save_view();
                    }
                } else {
                    if(!$this->cache->restore_saved_view())
                    {
                        if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                        {
                            $new_view = new file(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php");
                            $new_view->set_contents("<div class='alert alert-warning'>Brand new page without content.</div>");
                            if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."views".DS.$controller_name.DS.$view_name.".php"))
                                throw new exception("Impossible to load view on '{$controller_name}/{$view_name}'.");
                        }
                        $this->load_script();
                    }
                }

                return true;
            }
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    public function load_tab($pname = false)
    {
        try{
            $controller_name = $this->get_controller_name();
            $view_name = $this->get_view_name();
            if($this->reference === "core")
            {
                if($pname === false)
                {
                    if(!include(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS."index.php"))
                    {
                        $new_view = new file(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS."index.php");
                        $new_view->set_contents("<div class='alert alert-warning'>Brand new tab without content.</div>");
                        if(!include(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS."index.php"))
                            throw new exception("Impossible to load tab on '{$controller_name}/{$view_name}'.");
                    }
                } else {
                    if(!include(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php"))
                    {
                        $new_view = new file(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php");
                        $new_view->set_contents("<div class='alert alert-warning'>Brand new tab without content.</div>");
                        if(!include(program::$path."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php"))
                            throw new exception("Impossible to load tab on '{$controller_name}/{$view_name}/{$pname}'.");
                    }
                }
                return true;
            } else {
                if($pname === false)
                {
                    if(!include(program::$path."plugins".DS.$this->reference.DS."interface".DS."tabs".DS.$controller_name.DS.$view_name.".php"))
                    {
                        $new_view = new file(program::$path."plugins".DS.$this->reference.DS."ui".DS."tabs".DS.$controller_name.DS.$view_name.".php");
                        $new_view->set_contents("<div class='alert alert-warning'>Brand new tab without content.</div>");
                        if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."tabs".DS.$controller_name.DS.$view_name.".php"))
                            throw new exception("Impossible to load tab on '{$controller_name}/{$view_name}'.");
                    }
                } else {
                    if(!include(program::$path."plugins".DS.$this->reference.DS."interface".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php"))
                    {
                        $new_view = new file(program::$path."plugins".DS.$this->reference.DS."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php");
                        $new_view->set_contents("<div class='alert alert-warning'>Brand new tab without content.</div>");
                        if(!include(program::$path."plugins".DS.$this->reference.DS."ui".DS."tabs".DS.$controller_name.DS.$view_name.DS.$pname.".php"))
                            throw new exception("Impossible to load tab on '{$controller_name}/{$view_name}/{$pname}'.");
                    }
                }
                return true;
            }
        } 
        catch (exception $e)
        {
            return false;
        }
    }

}
