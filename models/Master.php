<?php
namespace Models;

use Models\Service;

class Master extends Service
{
    public  $id;
    public  $full_name;
    public  $phone;
    public  $salary;
    public  $status;
    static function TopEmployeeByPeriod($first_date, $last_date)
    {
        return mysqli_fetch_all(mysqli_query(Query::DB(), "SELECT e.full_name, (SELECT count(ser.id) FROM seans as s JOIN seans_services as ss ON ss.seans_id=s.id JOIN services as ser ON ser.id=ss.service_id JOIN employers_services AS es ON es.service_id=ser.id WHERE es.employer_id=e.id) as number, (SELECT sum(ser.price) FROM seans as s JOIN seans_services as ss ON ss.seans_id=s.id JOIN services as ser ON ser.id=ss.service_id JOIN employers_services AS es ON es.service_id=ser.id WHERE es.employer_id=e.id) as sum_price FROM employee as e ORDER BY sum_price DESC LIMIT 5;"));
    }
        static function MastersByServiceOnlyName($id)
    {
        $query = "SELECT e.full_name AS master_name FROM employers_services es JOIN employee e ON es.employer_id = e.id JOIN services s ON es.service_id = s.id WHERE s.id = $id;";
        $res = Query::Select($query);
        return $res;
    }
    static function MastersByService($id)
    {
        $query = "SELECT e.* FROM employers_services es JOIN employee e ON es.employer_id=e.id JOIN services s ON es.service_id=s.id WHERE s.id = $id;";
        $res = Query::Select($query);
        return $res;
    }
    static function Masters($search = "default")
    {
        $query = "SELECT * FROM  employee as e;";
        if ($search != "default")
            $query = "SELECT * FROM  employee as e WHERE e.full_name LIKE '$search%';";
        return Query::Select($query);
    }
    static function Master($id)
    {
        $query = "SELECT * FROM  employee as e WHERE id=$id;";
        $master = Query::Select($query)[0];
        $services = Service::ServicesByMasters($id);
        $query = "SELECT SUM(serv.price) FROM employee as e JOIN employers_services as es ON es.employer_id=e.id JOIN services as serv ON serv.id=es.service_id JOIN seans_services sserv ON sserv.service_id=serv.id JOIN seans as s ON s.id=sserv.seans_id WHERE e.id=$id;";
        $profit_from_seanses = Query::Select($query)[0][0];
        return [
            "id" => $id,
            "full_name" => $master[1],
            "phone" => $master[2],
            "services" => $services,
            "status" => $master[3],
            "salary" => $master[4],
            "profit_from_seanses" => $profit_from_seanses,
        ];
    }
    static function MastersByClient($id)
    {
        //echo $id;
        $data = Query::Select("SELECT e.* FROM clients as c JOIN seans as s ON c.id=s.client_id JOIN seans_services as ss ON s.id=ss.seans_id JOIN services as sr ON sr.id=ss.service_id JOIN employers_services as es ON es.service_id=sr.id JOIN employee as e ON e.id=es.employer_id WHERE c.id=$id GROUP BY e.id;");

        return $data;
    }
}