<?php
namespace Models;
use DateTime;
class FinanseData{
    public  $id;
    public  $type;
    public  $date;
    public  $category;
    public  $sum;
    static function min_and_max_dates()
    {
        $query = "SELECT min(t1.mn), max(t1.mx) FROM ( SELECT max(fin_data.date) AS `mx`, min(fin_data.date) AS `mn` FROM fin_data UNION SELECT max(seans.date) AS `mx`, min(seans.date) AS `mn` FROM seans UNION SELECT max(materials_in_storage.date) AS `mx`, min(materials_in_storage.date) AS `mn` FROM materials_in_storage ) AS t1;";
        //echo $query;
        return mysqli_fetch_all(mysqli_query(Query::DB(), $query));
    }
    static function DataByPeriod($first_date, $last_date)
    {

        $query = "SELECT fin_data.date AS `date`, fin_data.sum AS `sum`,fin_data.category as `type`,fin_data.type as `type2` FROM fin_data WHERE fin_data.date BETWEEN '$first_date' AND '$last_date' UNION SELECT seans.date AS `date`, services.price AS `sum`,'services' as `type`,'дохід' as `type2`  FROM seans JOIN seans_services ON seans_services.seans_id=seans.id JOIN services ON seans_services.service_id=services.id WHERE seans.date BETWEEN '$first_date' AND '$last_date' UNION SELECT materials_in_storage.date AS `date`, materials.material_price AS `sum`,'materials' as `type`,'витрати' as `type2` FROM materials_in_storage JOIN materials ON materials.id=materials_in_storage.material_id WHERE materials_in_storage.date BETWEEN '$first_date' AND '$last_date';";
        //echo $query . '-----------------------------------------';
        return mysqli_fetch_all(mysqli_query(Query::DB(), $query));

    }
    
}



?>