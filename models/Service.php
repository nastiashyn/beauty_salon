<?php

namespace Models;

class Service{
    public  $id;
    public  $name;
    public  $description;
    public  $price;
    public  $time;
    static function Service(int $id)
    {
        $query = "SELECT * FROM services WHERE id=$id;";
        $service = Query::select($query)[0];
        $masters_str = "";
        $materials = Material::MaterialsByService($service[0]);
        $masters = Master::MastersByServiceOnlyName($service[0]);
        $masters_arr = array();
        foreach ($masters as $master) {
            array_push($masters_arr, $master[0]);
        }
        if (count($masters_arr) != 0)
            $masters_str = join(',', $masters_arr);


        return [
            "id" => $service[0],
            "title" => $service[1],
            "masters" => $masters_str,
            "masters_arr" => Master::MastersByService($service[0]),
            "description" => $service[2],
            "price" => $service[3],
            "time" => $service[4],
            "materials" => $materials
        ];

    }
    static function Services(string $filter = "default", string $sort = "default", string $searchWord = "default", $master_id = null)
    {

        $filter_price = "";
        $filter_master = "";
        if ($filter != "default") {
            $filter_arr = explode("_", $filter);
            $filter_param = $filter_arr[0];
            $filter_value = $filter_arr[1];

            //echo $filter_value;
            if ($filter_param == "price") {
                $prices = explode("-", $filter_value);
                $price_1 = $prices[0];
                $price_2 = $prices[1];
                $filter_price = " s.price BETWEEN $price_1 AND $price_2";
            } else if ($filter_param == "master") {
                $filter_master = " sm.employer_id=$filter_value";
            }
        }
        $master_table = $filter_master != "" ? "JOIN employers_services AS sm ON s.id = sm.service_id" : "";

        if ($searchWord != "default") {

            $where = $filter == "default" ? "" : " AND ";
            $where = $where . $filter_price . $filter_master;
            if ($sort == "title")
                $query = "SELECT s.* FROM services as s $master_table WHERE s.name like '$searchWord%' $where  ORDER BY s.name;";
            else if ($sort == "price")
                $query = "SELECT s.* FROM services as s $master_table WHERE s.name like '$searchWord%' $where ORDER BY s.price;";
            else
                $query = "SELECT s.* FROM services as s $master_table WHERE s.name like '$searchWord%' $where;";
        } else {
            $where = $filter == "default" ? "" : " WHERE ";
            $where = $where . $filter_price . $filter_master;
            if ($sort == "title")
                $query = "SELECT s.* FROM services as s $master_table $where ORDER BY s.name;";
            else if ($sort == "price")
                $query = "SELECT s.* FROM services as s $master_table $where ORDER BY price;";
            else
                $query = "SELECT s.* FROM services as s $master_table $where ;";
        }
        //echo $query;
        return Query::Select($query);
    }

    static function ServicesByMasters(int $id)
    {
        $query = "SELECT s.* FROM employers_services as e JOIN services as s ON e.service_id=s.id WHERE e.employer_id=$id;";
        $services = Query::Select($query);
        $res = [];
        foreach ($services as $service) {
            $s = Service::Service($service[0]);
            array_push($res, $s);
        }
        return $res;
    }
    static function ServicesByMastersOnlyName(int $id)
    {
        $query = "SELECT s.* FROM employers_services as e JOIN services as s ON e.service_id=s.id WHERE e.employer_id=$id;";
        $res = Query::Select($query);

        return $res;
    }
    static function ServicesBySeans($id)
    {
        return Query::Select("SELECT serv.*,e.id as master_id,e.full_name FROM seans AS s JOIN seans_services AS ss ON ss.seans_id=s.id JOIN services AS serv ON ss.service_id=serv.id JOIN employers_services AS es ON es.service_id=serv.id JOIN employee AS e ON es.employer_id=e.id JOIN clients AS c ON c.id=s.client_id WHERE s.id=$id;");
    }
    static function ServicesByClient($id)
    {
        $data = Query::Select("SELECT sr.* FROM clients as c JOIN seans as s ON c.id=s.client_id JOIN seans_services as ss ON s.id=ss.seans_id JOIN services as sr ON sr.id=ss.service_id WHERE c.id=$id GROUP BY sr.id;");

        return $data;
    }
    static function TopServicesByPeriod($first_date, $last_date)
    {
        return mysqli_fetch_all(mysqli_query(Query::DB(), "SELECT s.name, (SELECT COUNT(ss.id) FROM seans_services as ss WHERE ss.service_id=s.id) as number, (SELECT COUNT(ss.id) FROM seans_services as ss WHERE ss.service_id=s.id)*s.price as sum_price FROM services as s ORDER BY sum_price DESC LIMIT 5;"));
    }
}