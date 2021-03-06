<?php
namespace controllers\page;
use core\backend\components\mvc\controllers\page;
use core\program;
use core\common\regex;
use core\backend\components\filesystem\file;

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

class admin extends page
{

    protected function on_initialize()
    {
        $this->require_authentication();
        $this->require_group(array("Admin","Moderator"));
        $this->send(["blacklist"=>[],"buttons"=>$this->databases->get_mysql_database_by_id()->get_model()->get_menu_buttons_by_user_and_group_and_granted($this->user->get_id(),$this->user->get_group())],"menu");
    }

    public function index()
    {
        
    }

    public function dashboard()
    {

    }

    public function groups()
    {
        $users = $this->databases->get_mysql_database_by_id()->get_model();
        $this->send($users->get_user_groups(),"groups");
    }

    public function group($pname)
    {
        if($pname === false) $this->redirect("/admin/groups");
        $users = $this->databases->get_mysql_database_by_id()->get_model();
        if(regex::is_numeric($pname))
        {
            $groups = $users->get_user_groups_by_id($pname);
        }
        else if(regex::is_slug($pname))
        {
            $groups = $users->get_user_groups_by_name($pname);
        }
        else
        {
            $this->redirect("/admin/groups");
        }
        if(count($groups) >= 1)
        {
            $this->send($groups[0],"group");
        }
        else
        {
            $this->redirect("/admin/groups");
        }
        $this->send($users->get_controller_views(200),"pages");
        $this->send($users->get_options(200),"options");
        $this->send($users->get_permissions(200),"permissions");
    }

    public function permissions()
    {
        $this->send($this->databases->get_mysql_database_by_id()->get_model()->get_permissions(),"permissions");
    }

    public function permission($pid = 0)
    {
        $id = intval($pid);
        if($id)
        {
            $this->send($this->databases->get_mysql_database_by_id()->get_model()->get_permission_by_id($id),"permission");
            $this->send($this->databases->get_mysql_database_by_id()->get_model()->get_controller_views(200),"pages");
        } else {
            $this->redirect("/admin/permissions");
        }
        
    }

    public function users()
    {
        $users_model = $this->databases->get_mysql_database_by_id()->get_model();
        $this->send($users_model->get_users(),"users");
        $this->send($users_model->get_user_groups(),"groups");
    }

    public function user($pname)
    {
        if($pname === false) $this->redirect("/admin/users");
        $users = $this->databases->get_mysql_database_by_id()->get_model();
        if(regex::is_numeric($pname))
        {
            $user = $users->get_user_by_id($pname);
        }
        else if(regex::is_slug($pname))
        {
            $user = $users->get_user_by_name($pname);
        }
        else
        {
            $this->redirect("/admin/users");
        }
        if($user)
        {
            $this->send($user,"user");
        }
        else
        {
            $this->redirect("/admin/users");
        }
        $this->send($users->get_controller_views(200),"pages");
        $this->send($users->get_options(200),"options");
        $this->send($users->get_permissions(200),"permissions");
    }

    public function system()
    {
    }

    public function pages()
    {
        $this->send($this->databases->get_mysql_database_by_id()->get_model()->get_controllers(),"controllers");
    }

    public function database()
    {
        if(isset($_REQUEST["sql"])){
            $this->send($this->databases->get_mysql_database_by_id()->get_connection()->get_select_query($_REQUEST["sql"]),"data");
        } else {
            $this->send($this->databases->get_mysql_database_by_id()->get_connection()->get_select_query("show tables"),"data");
        }
    }

    public function logs()
    {
        $log_file = new file(program::$path."logs/exceptions/".date("Y").DS.date("F").DS.date("j").".log",false);
        $this->send(json_decode($log_file->get_contents()),"logs");
    }

    public function plugins()
    {
        $plugins = array();
        foreach(program::$plugins as $plugin)
        {
            $plugins[] = new $plugin();
        }
        $this->send($plugins,"plugins");
    }

    public function firewall()
    {

    }

}