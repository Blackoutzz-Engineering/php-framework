<?php
namespace core\frontend\components\widgets\admin;
use core\frontend\components\widget;
use core\frontend\html\elements\div;
use core\frontend\html\elements\hr;

class log extends widget 
{

    public function get_logs()
    {
        foreach($log->get_daily_logs() as $id => $logs)
        {
            $elog = new exception_log($logs[0]);
            sstr::writeline("<div class='alert alert-warning col-lg-12' id='{$id}'>");
            sstr::write($elog->get_user()->get_gravatar("width:25px;"));
            sstr::writeline("<strong class='pull-left'> ".$elog->get_user()->get_name()." </strong><hr/>");
            foreach($logs as $item){
                $item = new exception_log($item);
                sstr::writeline("<div id='exception'>".$item->get_message()."</div>");
            }
            sstr::writeline("<hr/><div class='pull-right' id='date'>");
            sstr::writeline($elog->get_date()->get_elasped_time()." <i class='fa fa-clock'></i>");
            sstr::writeline("</div>");
            sstr::writeline("</div>");
        }

    }

}
