<?php
namespace core\frontend\components\widgets;
use core\frontend\components\widget;
use core\frontend\html\elements\img;

class gravatar extends widget
{
    protected $email = "";
    protected $username = "";

    public function __toHtml()
    {
        return new img([
            "src" => "https://secure.gravatar.com/avatar/". md5($this->email). ".png",
            "alt" => $this->username
        ]);
    }

}