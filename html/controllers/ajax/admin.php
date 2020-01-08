<?php
namespace controllers\ajax;
use core\backend\components\mvc\controllers\ajax;
use core\program;
use core\common\str;

/**
 * admin short summary.
 *
 * admin description.
 *
 * @Version 1.0
 * @Author  mick@blackoutzz.me
 * @Twitter @Mick4Secure
 * @Github  @Blackoutzz
 * @Website https://Blackoutzz.me
 **/


class admin extends ajax
{

    public function get_users()
    {
        $model = $this->get_system_database();
        $users = $model->get_users();
        $this->send($users,"users");
        $this->load_tab("users");
        return true;
    }

    public function add_user()
    {    
        if(isset($_REQUEST["email"]) && isset($_REQUEST["username"]) && isset($_REQUEST["group"]))
        {
            if($this->get_user()->can("Admin Access"))
            {
                $password = str::get_safe_random(32);
                $model = $this->get_system_database();
                if($user = $model->create_user($_REQUEST["username"],$password,$_REQUEST["email"],$_REQUEST["group"]))
                {
                    $subject = 'App Invite';
                    $message = "Hi.\n".
                    'Your credentials :'."\n\n".'Username : '.$user->get_name()."\n".'Secure Password : '.$password."\n\n".
                    'Best Regards,';
                    $headers = 'From: noreply'."\r\n";
                    return mail($_REQUEST["email"], $subject, $message, $headers);
                }
            }
        }
        return false;
    }

    public function update_user($pid)
    {
        $id = intval($pid);
        if($this->get_user()->can("Admin Access"))
        {
            $user_db = $this->get_system_database();
            if($user = $user_db->get_user_by_id($id))
            {
                $password = str::get_safe_random(32);
                $user->set_password($password);
                if($user->password === program::$cryptography->hash($password))
                {
                    if($user->save())
                    {
                        $subject = 'App Warning : Password Reset';
                        $message = "Hi, ".$user->get_name()."\n".
                        'Your credentials has been reset :'."\n\n".'Username : '.$user->name."\n".'Secure Password : '.$password."\n\n".
                        'Best Regards,';
                        $headers = 'From: noreply'."\r\n";
                        mail($user->email, $subject, $message, $headers);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function add_group($pname)
    {
        $name = (string) $pname;
        if($this->get_user()->can("Admin Access"))
        {
            $model = $this->get_system_database();
            if($model->create_user_group($name)) return true;
        }
        return false;
    }

    public function group($action,$selection)
    {
        if($this->get_user()->can("Admin Access"))
        {
            if($action === "new")
            {
                if($selection === "page")
                {
                    if(isset($_REQUEST["group"]) && isset($_REQUEST["page"]))
                    {
                        $model = $this->get_system_database();
                        if($model->create_user_group_controller_view($_REQUEST["group"],$_REQUEST["page"],1)) return true;
                    }
                    return false;
                }
                elseif($selection === "option")
                {
                    if(isset($_REQUEST["group"]) && isset($_REQUEST["option"]) && isset($_REQUEST["value"]))
                    {
                        $model = $this->get_system_database();
                        if($model->create_user_group_option($_REQUEST["group"],$_REQUEST["option"],$_REQUEST)) return true;
                    }
                    return false;
                }
                elseif($selection === "permission")
                {
                    if(isset($_REQUEST["group"]) && isset($_REQUEST["permission"]))
                    {
                        $model = $this->get_system_database();
                        if($model->create_user_group_permission($_REQUEST["group"],$_REQUEST["permission"],1)) return true;
                    }
                }
            }
        }
        return false;
    }

    public function add_permissions($pname)
    {
            $name = (string) $pname;
            if($this->get_user()->can("Admin Access"))
            {
                $model = $this->get_system_database();
                if($model->create_permission($name,$_REQUEST["description"])) return true;
            }
        
        return false;
    }

    public function update_plugins($action,$pslug)
    {
        if($action === "install")
        {
            if($this->is_slug($pslug))
            {
                $plugins = program::$plugins;
                foreach($plugins as $slug => $plugin)
                {
                    if($slug === $pslug)
                    {
                        $new_plugin = new $plugin();
                        return $new_plugin->install();
                    }
                }
            }
            return false;
        }

        if($action === "uninstall")
        {
            if($this->is_slug($pslug))
            {
                $plugins = program::$plugins;
                foreach($plugins as $slug => $plugin)
                {
                    if($slug === $pslug)
                    {
                        $new_plugin = new $plugin();
                        return $new_plugin->uninstall();
                    }
                }
            }
        }
        return false;
    }

}
