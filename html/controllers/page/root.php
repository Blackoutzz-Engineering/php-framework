<?php
namespace controllers\page;
use core\backend\components\mvc\controllers\page;
use core\backend\components\system\programming\baker;
use core\common\components\stack;
use core\backend\system\environment;
use core\program;

class root extends page
{

    public function on_initialize()
    {
        $this->send(["blacklist"=>[],"buttons"=>$this->databases->get_mysql_database_by_id()->get_model()->get_menu_buttons_by_user_and_group_and_granted($this->user->get_id(),$this->user->get_group())],"menu");
    }

    public function index()
    {
        $data = '{
  "country": {
    "ourselves": 1901158348.1211357,
    "word": -1712292144.1919456,
    "activity": "minute",
    "nodded": [
      false,
      "chemical",
      false,
      false,
      241893407.61943674,
      -769201832.7926388
    ],
    "silver": -207547456,
    "him": -1927448075.3005161
  },
  "after": -1017310852.7010589,
  "trade": "busy",
  "village": false,
  "distance": -1510140017.4940476,
  "find": true
}';
        $baker = new baker();
        $baker->bake($data);
    }

    public function dashboard()
    {

    }

    public function login()
    {
        if($this->user->is_authenticated()) $this->redirect("/");
    }

    public function forgot()
    {

    }

    public function register()
    {

    }

}
