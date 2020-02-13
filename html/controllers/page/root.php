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
    "_id": "5e40cd17b4b392e0f6bc5c39",
    "index": 0,
    "guid": "bd1d29e6-c1d7-4666-98fd-e286ad5d02a9",
    "isActive": true,
    "balance": "$2,443.49",
    "picture": "http://placehold.it/32x32",
    "age": 27,
    "eyeColor": "green",
    "name": {
      "first": "Frank",
      "last": "Wiggins"
    },
    "company": "ACIUM",
    "email": "frank.wiggins@acium.org",
    "phone": "+1 (906) 600-2952",
    "address": "244 Dahlgreen Place, Salunga, Wisconsin, 2282",
    "about": "Proident voluptate culpa ad quis elit velit nostrud. Ullamco voluptate ipsum do laboris aliquip labore anim tempor officia culpa ut ex eu anim. Magna laborum voluptate consequat eu Lorem nisi laboris eu ad ad. Tempor irure fugiat elit eiusmod mollit. Commodo quis labore eu reprehenderit aute occaecat aliqua enim pariatur ea sunt. Fugiat laborum qui nulla enim sit ullamco ad eu occaecat. Eu sit sunt exercitation Lorem.",
    "registered": "Saturday, July 16, 2016 2:07 AM",
    "latitude": "-46.394566",
    "longitude": "161.714067",
    "tags": [
      "ad",
      "minim",
      "cupidatat",
      "non",
      "laborum"
    ],
    "range": [
      0,
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      9
    ],
    "friends": [
      {
        "id": 0,
        "name": "Sanders Vang"
      },
      {
        "id": 1,
        "name": "Allyson Cleveland"
      },
      {
        "id": 2,
        "name": "Shawn Mckinney"
      }
    ],
    "greeting": "Hello, Frank! You have 8 unread messages.",
    "favoriteFruit": "banana"
  }';
        $baker = new baker($data);
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
