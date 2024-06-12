<?php
session_start();
require_once '../../blocks/models.php';
use Models\Material;
use Models\Service;



$id = $_GET["id"];
$services = Service::ServicesByMasters($id);
if ($id == 0)
    $services = Service::Services();
$res = [];
$status="";

if(!Material::CheckMaterialsByService($id)) $status="Не вистачає матеріалів на складі";
foreach ($services as $service) {
    array_push($res, [
        "id" => $service["id"],
        "name" => $service["title"],
        "description"=>$service["description"],
        "status" => $status,
    ]);
}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>