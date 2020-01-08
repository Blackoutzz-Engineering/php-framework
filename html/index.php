<?php
require('vendor/autoload.php');
require('main.php');
if(file_exists(framework\main::$path."config.php"))
{
    include(framework\main::$path."config.php");
    if(isset($database) && isset($salt) && isset($algo)) $argv = ["db"=>$database,"algo"=>$algo,"salt"=>$salt];
}
$main = new framework\main($argv);
