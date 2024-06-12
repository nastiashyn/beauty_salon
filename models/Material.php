<?php
namespace Models;

class Material
{
    public  $id;
    public  $title;
    public  $material_price;
    public  $description;
    public  $days_number_expiration;
    static function Materials()
    {
        $query = "SELECT * FROM materials as m;";
        return mysqli_fetch_all(mysqli_query(Query::DB(), $query));
    }

    static function CheckMaterialsByService($id)
    {
        $materials = Material::MaterialsByService($id);
        foreach ($materials as $material) {
            if ($material["number"] > $material["number_on_storage"])
                return false;
        }
        return true;
    }
    static function MaterialsByService($id)
    {
        $res = [];
        $query = "SELECT m.*,(select min(ms.date) from materials_in_storage as ms where ms.material_id=m.id) as date,sm.number,(select count(ms.id) from materials_in_storage as ms where ms.material_id=m.id) AS number_on_storage FROM service_materials as sm JOIN materials as m ON sm.material_id = m.id JOIN services s ON sm.service_id = s.id WHERE s.id=$id GROUP by m.id;";

        $data = Query::Select($query);
        foreach ($data as $item) {
            array_push($res, [
                "id" => $item[0],
                "title" => $item[1],
                "price" => $item[2],
                "description" => $item[3],
                "days_number_expiration" => $item[4],
                "unit" => $item[5],
                "number_for_price" => $item[6],
                "date" => $item[7],
                "number" => $item[8],
                "number_on_storage" => $item[9],
            ]);
        }
        return $res;
    }
    static function MaterialsOnStorage()
    {
        $res = [];
        $query = "SELECT m.*,ms.date as date,COUNT(ms.id) AS number_on_storage FROM materials_in_storage as ms JOIN materials as m ON ms.material_id = m.id GROUP by m.id;";

        $data = Query::Select($query);
        foreach ($data as $item) {
            array_push($res, [
                "title" => $item[1],
                "price" => $item[2],
                "description" => $item[3],
                "number_on_storage" => $item[8] . " " . $item[5],
                "date" => $item[7],
                "days_number_expiration" => $item[4],

            ]);
        }
        return $res;
    }

}



?>