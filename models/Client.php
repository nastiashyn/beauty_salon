<?php

namespace Models;
use DateTime;
require_once 'C:\Users\Julie\source\beauty_salon/models/Service.php';
use Models\Service;

class Client extends Service
{
    public  $id;
    public  $full_name;
    public  $phone;
    public  $date_of_birth;
    public  $email;
    public  $instagram;
    public  $telegram;
    static function Clients()
    {
        $query = "SELECT * FROM  clients as c;";
        return Query::Select($query);
    }
    static function Client($id)
    {
        return Query::SelectItem("Select * FROM clients WHERE id=$id");
    }
    static function ClientsFull()
    {
        $data= Query::Select("SELECT c.id,c.full_name, c.date_of_birth,c.phone,c.email,c.telegram,c.instagram,(SELECT COUNT(s.id) FROM seans as s WHERE s.client_id=c.id) as seans_number FROM clients as c;");
        return $data;
    }

    static function ClientsFullByMaster($id)
    {
        $query="SELECT c.id,c.full_name, c.date_of_birth,c.phone,c.email,c.telegram,c.instagram,COUNT(s.id) as seans_number FROM clients as c JOIN seans as s ON c.id=s.client_id JOIN seans_services as ss ON s.id=ss.seans_id JOIN services as sr ON sr.id=ss.service_id JOIN employers_services as es ON es.service_id=sr.id JOIN employee as e ON e.id=es.employer_id WHERE e.id=$id;";
        //echo $query;
        return Query::Select($query);

    }
     static function TopClientsByPeriod($first_date, $last_date)
    {
        return mysqli_fetch_all(mysqli_query(Query::DB(), "SELECT c.full_name, (SELECT COUNT(s.id) FROM seans as s WHERE s.client_id=c.id) as number, (SELECT sum(ser.price) FROM seans as s JOIN seans_services as ss ON ss.seans_id=s.id JOIN services as ser ON ser.id=ss.service_id  WHERE s.client_id=c.id) as sum_price FROM clients as c ORDER BY sum_price DESC LIMIT 5;"));
    }
}


?>