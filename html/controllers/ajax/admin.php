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
//  reviewed tested
    public function get_users()
    {
        $model = $this->databases->get_mysql_database_by_id()->get_model();
        $users = $model->get_users();
        $this->send($users,"users");
//        $this->load_tab("users");
        return true;
    }
//  Reviewed tested
    public function add_user()
    {
        if(isset($_REQUEST["email"]) && isset($_REQUEST["username"]) && isset($_REQUEST["group"]))
        {
            if($this->user->can("Admin Access"))
            {
                $password = program::$cryptography->hash(str::get_safe_random(32));
                $model = $this->databases->get_mysql_database_by_id()->get_model();
                if($user = $model->create_user($_REQUEST["username"],$password,$_REQUEST["email"],$_REQUEST["group"]))
                {
                    $subject = 'App Invite';
                    $message = "Hi.\n".
                    'Your credentials :'."\n\n".'Username : '.$user->get_name()."\n".'Secure Password : '.$password."\n\n".
                    'Best Regards, The almighty blackoutzz framework.';
                    $headers = 'From: noreply'."\r\n";
                    return mail($_REQUEST["email"], $subject, $message, $headers);
                }
            }
        }
        return false;
    }

//  reviewed and not working for now
    public function add_reset_user_password()
    {
        $id = intval($_REQUEST["id"]);
        if($this->user->can("Admin Access"))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if($user = $model->get_user_by_id($id))
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
                        'Best Regards, The almighty blackoutzz framework.';
                        $headers = 'From: noreply'."\r\n";
                        return mail($user->email, $subject, $message, $headers);
                    }
                }
            }
        }
        return false;
    }
// reviewed tested
    public function add_user_group()
    {
        $name = (string) $_REQUEST["name"];
        if($this->user->can("Admin Access"))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if($model->create_user_group($name))
            {
                return true;
            }
        }
        return false;
    }
// reviewed tested
    public function add_user_group_controller_view()
    {
        if(isset($_REQUEST["group"]) && isset($_REQUEST["page"]))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if($model->create_user_group_controller_view($_REQUEST["group"],$_REQUEST["page"],1))
            {
                return true;
            }
        }
        return false;
    }
// reviewed tested
    public function add_user_group_option()
    {
        if(isset($_REQUEST["group"]) && isset($_REQUEST["option"]) && isset($_REQUEST["value"]))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if ($model->create_user_group_option($_REQUEST["group"], $_REQUEST["option"], $_REQUEST["value"]))
            {
                return true;
            }
            return false;
        }
        return false;
    }
// reviewed tested
    public function add_user_group_permission()
    {
        if(isset($_REQUEST["group"]) && isset($_REQUEST["permission"]))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if($model->create_user_group_permission($_REQUEST["group"],$_REQUEST["permission"],1))
            {
                return true;
            }
        }
        return false;
    }
// reviewed tested
    public function add_permission()
    {
        $name = (string) $_REQUEST["name"];
        if($this->user->can("Admin Access"))
        {
            $model = $this->databases->get_mysql_database_by_id()->get_model();
            if($model->create_permission($name,$_REQUEST["description"]))
            {
                return true;
            }
        }
        return false;
    }
//    lets not touch it for now
    public function add_plugins()
    {
//        $model = $this->databases->get_mysql_database_by_id()->get_model();
        if($this->is_slug($_REQUEST["slug"]))
        {
            $plugins = program::$plugins;
            foreach($plugins as $slug => $plugin)
            {
                if($slug === $_REQUEST["slug"])
                {
                    $new_plugin = new $plugin();
                    return $new_plugin->install();
                }
            }
        }
        return false;
    }
//    lets not touch it for now
    public function delete_plugins()
    {
        if($this->is_slug($_REQUEST["slug"]))
        {
            $plugins = program::$plugins;
            foreach($plugins as $slug => $plugin)
            {
                if($slug === $_REQUEST["slug"])
                {
                    $new_plugin = new $plugin();
                    return $new_plugin->uninstall();
                }
            }
        }
        return false;
    }
}
