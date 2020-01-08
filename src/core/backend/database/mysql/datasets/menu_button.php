<?php
namespace core\backend\database\mysql\datasets;
use core\backend\database\mysql\dataset;
use core\backend\database\mysql\model;

class menu_button extends dataset
{

    protected $name = "";

    protected $controller_view = NULL;

    protected $category = NULL;

    public function save($pid = 0)
    {
        if($this->exist())
        {
            return $this->execute_prepared_update_query("UPDATE `menu_buttons` SET name=?,category=?,controller_view=? WHERE id=?","siii",array($this->name,$this->category,$this->controller_view,$this->id),$pid);
        } else {
            return $this->execute_prepared_insert_query("INSERT INTO `menu_buttons` (`name`,`controller_view`,`category`) values (?,?,?)","sii",array($this->name,$this->controller_view,$this->category),$pid);
        }
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($pname)
    {
        $this->name = $this->get_sanitized_string($pname);
    }

    public function get_category()
    {
        return $this->database()->get_model()->get_menu_category_by_id($this->category);
    }

    public function get_controller_view()
    {
        return $this->database()->get_model()->get_controller_view_by_id($this->controller_view);
    }

}
