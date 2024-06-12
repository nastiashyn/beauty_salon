<?php


namespace Models;

use Models\Service;

class Seanse extends Service
{
    public  $id;
    public  $client_id;
    public  $date;
    static function Seanses($start, $end,$param,$param_value=null)
    {
        $param_="";
        if($param=="master") $param_="es.employer_id=$param_value AND";
        else if($param=="client") $param_="c.id=$param_value AND ";
        $query="SELECT s.id,s.date,c.full_name,c.phone,MAX(serv.name) FROM seans AS s JOIN seans_services AS ss ON ss.seans_id=s.id JOIN services AS serv ON ss.service_id=serv.id JOIN clients AS c ON c.id=s.client_id JOIN employers_services as es ON es.service_id=serv.id WHERE $param_ s.date BETWEEN '$start' AND '$end' GROUP BY s.id;";
        //echo $query;
        return Query::Select($query);
    }
}