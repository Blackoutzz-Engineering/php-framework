<?php
namespace core\frontend\components\widgets;
use core\frontend\components\widget;
use core\frontend\html\elements\input;

class csrf_token extends widget
{
    protected $token;

    public function __toHtml()
    {
        return new input([
            "type" => "hidden",
            "value" => $this->token,
            "name" => "csrf_token",
            "id" => "user_token",
        ]);
    }

}