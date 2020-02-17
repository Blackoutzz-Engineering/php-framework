<?php
namespace core\backend\network\dns;
use core\backend\database\dataset;

class query extends dataset
{

    protected $host;

    

    public function has_record($ptype) : bool
    {
        $type = strtoupper(trim($ptype));
        switch($type)
        {
            case "MX":
                return checkdnsrr($this->host,$type);
            case "A":
                return checkdnsrr($this->host,$type);
            case "AAAA":
                return checkdnsrr($this->host,$type);
            case "TXT":
                return checkdnsrr($this->host,$type);
            case "CAA":
                return checkdnsrr($this->host,$type);
            case "NS":
                return checkdnsrr($this->host,$type);
            case "SRV":
                return checkdnsrr($this->host,$type);
            default:
                return false;
        }
    }

}