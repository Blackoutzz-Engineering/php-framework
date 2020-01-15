<?php
namespace core\backend\components\mvc;
use core\program;
use core\backend\components\mvc\user;
use core\backend\database\mysql\model;
use core\component;
use core\common\str;
use core\common\exception;
use core\backend\mvc\controller\cache;
use core\backend\mvc\controller\routing;
use core\backend\mvc\controller\databases;
use core\frontend\components\mvc\controller_view;

/**
 * Controller
 * 
 * Application base controller for MVC
 * 
 * @version 1.0
 * @author  Mickael Nadeau
 * @twitter @Mick4Secure
 * @github  @Blackoutzz
 * @website https://Blackoutzz.me
 **/

abstract class controller
{

    protected $reference;

    protected $view_data = array();

    protected $user;

    protected $databases;

    protected $routing;

    protected $cache;

    public function __construct($preference = "core")
    {
        $this->reference = $preference;
        $this->user = program::$users[0];
        $this->databases = new databases();
        $this->routing = new routing();
        $this->cache = new cache($preference);
        $this->on_initialize();
    }

    public function __toString()
    {
        $classname = get_class($this);
        return array_pop(explode('\\',$classname));
    }

    protected function has_view()
    {
        try
        {
            $view = trim(strtolower(str_replace("-","_",$this->routing->get_view_name())));
            if(preg_match('~^([A-z]+[A-z-_]*[A-z]+)$~im',$view))
            {
                if(method_exists('core\\backend\\components\\mvc\\controller',$view)) 
                    throw new exception("Reserved view name");
                if(method_exists($this,$view))
                {
                    return true;
                } else {
                    throw new exception("No view configured inside controller");
                }
            } else {
                throw new exception("Invalid view name");
            }
        }
        catch (exception $e)
        {
            return false;
        }
    }

    protected function prepare_view()
    {
        try
        {
            $no_parameter = 0;
            $view_parameters = $this->routing->get_parameters();
            $count_view_parameters = count($view_parameters);
            $view_name = $this->routing->get_view_name();
            $ref = new \ReflectionMethod($this,str_replace(["-"," "],"_",$view_name));
            $count_needed_parameters = count($ref->getParameters());
            //If No parameters are needed they will be ignored
            if($count_view_parameters === $no_parameter
            && $count_needed_parameters === $no_parameter)
            {
                return call_user_func(array($this,str_replace(["-"," "],"_",$view_name)));
            }
            //If Parameters match perfectly
            if($count_view_parameters === $count_needed_parameters)
            {
                return call_user_func_array(array($this,str_replace(["-"," "],"_",$view_name)),$view_parameters);
            }
            //View will be loaded with the first parameter provided
            if($count_view_parameters > $count_needed_parameters)
            {
                $params = array();
                for($i=0; $i > $count_needed_parameters; $i++)
                {
                    $params[] = $view_parameters[$i];

                }
                return call_user_func_array(array($this,str_replace(["-"," "],"_",$view_name)),$params);

            }
            //View will be loaded with the first parameter provided and add false to the rest
            if($count_view_parameters < $count_needed_parameters)
            {
                $params = array();
                foreach($view_parameters as $param)
                {
                    $params[] = $param;
                }
                for($i=count($params);$i < $count_needed_parameters;$i++)
                {
                    $params[] = false;
                }
                return call_user_func_array(array($this,str_replace(["-"," "],"_",$view_name)),$params);
            }
            //Missing or Invalid Parameters
            throw new exception("Invalid parameters.");
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    protected function create_view()
    {
        return new controller_view($this->reference,$this->cache,$this->view_data);
    }

    protected function has_access($pid = 0)
    {
        $id = intval($pid);
        try
        {
            if($this->routing->is_managed())
            {
                if(isset(program::$users) && program::$users[$id] instanceof user)
                {
                    if(program::$users[$id]->has_access()) return true;
                    throw new exception("Access denied to access view");
                }
                throw new exception("User doesn't have access");
            } else {
                return true;
            }
            
        } 
        catch (exception $e)
        {
            return false;
        }
    }

    protected function require_permission($ppermission)
    {
        try
        {
            if(isset($this->user))
            {
                if(is_array($ppermission))
                {
                    foreach($ppermission as $permission)
                    {
                        if($this->user->can($permission)) return true;
                    }
                    throw new exception("Required permission missing");
                } else {
                    if($this->user->can($ppermission)) return true;
                    throw new exception("Permission Required missing");
                }
            }
            throw new exception("No permission can be used without users.");
        } 
        catch(exception $e)
        {
            $this->on_permission_requirement_failed();
            return false;
        }
    }

    protected function require_permissions($ppermission)
    {
        try
        {
            if(isset($this->user))
            {
                if(is_array($ppermission))
                {
                    foreach($ppermission as $permission)
                    {
                        if($this->user->can($permission)) continue;
                        throw new exception("Required permission missing");
                    }
                    return true;
                } else {
                    if($this->user->can($ppermission)) return true;
                    throw new exception("Permission Required missing");
                }
            }
            throw new exception("No permissions can be used without users.");
        } 
        catch(exception $e)
        {
            $this->on_permission_requirement_failed();
            return false;
        }
    }

    protected function require_authentication()
    {
        try
        {
            if($this->user->is_authenticated()) return true;
            throw new exception("Authentication is required to access this page");
        } 
        catch(exception $e)
        {
            $this->on_login_requirement_failed();
            return false;
        }
    }

    protected function require_group($pgroup)
    {
        if(is_array($pgroup))
        {
            foreach($pgroup as $group)
            {
                //if($this->get_databases()->get_mysql_database_by_id()->get_model()->is_user_group($group))
                //{
                //    if($this->get_user()->get_group()->get_name() === $group->get_name()) return true;
                //} 
                if(is_string($group))
                {
                    if($this->user->get_group()->get_name() === $group) return true;
                } 
                elseif(is_numeric($group) || is_integer($group))
                {
                    if($this->user->get_group()->get_id() === $group) return true;
                }
            }
        } 
        //elseif($this->get_databases()->get_mysql_database_by_id()->is_user_group($pgroup)) 
        //{
        ///    if($this->get_user()->get_group()->get_name() === $pgroup->get_name()) return true;
        //} 
        if(is_string($pgroup))
        {
            if($this->user->get_group()->get_name() === $pgroup) return true;
        } 
        elseif(is_numeric($pgroup) || is_integer($pgroup))
        {
            if($this->user->get_group()->get_id() === $pgroup) return true;
        }
        $this->on_group_requirement_failed();
        return false;
    }

    protected function require_plugin($pplugin)
    {
        try
        {
            if(class_exists("core\\plugin"))
            {
                foreach(program::get_plugins() as $plugin_slug => $plugin)
                {
                    if($plugin_slug === $pplugin) return true;
                    if($pplugin === $plugin) return true;
                }
                throw new exception("Plugin {$pplugin} Required and Installed.");
            }
            throw new exception("Plugins can't be installed in the app");
        } 
        catch (exception $e)
        {
            $this->on_plugin_requirement_failed();
            return false;
        }
    }

    protected function require_caching()
    {
        $this->cache->activate();
        return (!$this->cache->is_saved());
    }

    protected function send($pvar,$pname = false)
    {
        try
        {
            if($pname === false)
            {
                $this->view_data[] = $pvar;
            } else {
                $this->view_data[$pname] = $pvar;
            }
            return true;
        }
        catch (exception $e)
        {
            return false;
        }
    }

    protected function redirect($ppath = "")
    {
        try 
        {
            if($ppath != "")
            {
                header("Location: {$ppath}");
                program::end(307);
            } else {
                if(method_exists($this,"dashboard"))
                {
                    if($this->has_access() && program::$user->is_connected())
                    {
                        if($this->controller_name != "root")
                        {
                            header("Location: /{$this->controller_name}/");
                            program::end(307);
                        } else {
                            header("Location: /");
                            program::end(307);
                        }
                    }
                }
                if(method_exists($this,"index"))
                {
                    if($this->has_access())
                    {
                        if($this->controller_name != "root")
                        {
                            header("Location: /{$this->controller_name}/");
                            program::end(307);
                        } else {
                            header("Location: /");
                            program::end(307);
                        }
                    }
                }
                header("Location: /");
                program::end(307);
            }
        } 
        catch (exception $e)
        {
            header("Location: /");
            program::end(307);
        }
    }

    public function initialize()
    {
        return false;
    }

    protected function on_initialize()
    {
        //Override this to execute custom code.
    }

    protected function on_group_requirement_failed()
    {
        //Override this to execute custom code.
        $this->on_requirement_failed();
    }

    protected function on_login_requirement_failed()
    {
        //Override this to execute custom code.
        $this->on_requirement_failed();
    }

    protected function on_permission_requirement_failed()
    {
        //Override this to execute custom code.
        $this->on_requirement_failed();
    }

    protected function on_plugin_requirement_failed()
    {
        //Override this to execute custom code.
        $this->on_requirement_failed();
    }

    protected function on_requirement_failed()
    {
        $this->redirect("/");
    }

    protected function on_access_failed()
    {
        //Override this to execute custom code.
        $this->redirect("/");
    }


}
