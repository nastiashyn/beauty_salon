<?php
session_start();
require_once '../../blocks/models.php';


use Models\Master;
use Models\Service;
require_once '../../blocks/models.php';

$filter = $_GET["filter"];
$sort = $_GET["sort"];
$searchWord = $_GET["searchword"];
$services = Service::Services($filter, $sort, $searchWord);
if($_SESSION['user']['master_id']!=null){
    $services=Service::Services('master_' . $_SESSION['user']['master_id'], $sort, $searchWord);
}
$data = [];
foreach ($services as $service) {
    $masters_str = "";
    $masters = Master::MastersByServiceOnlyName($service[0]);
    $masters_arr = array();
    foreach ($masters as $master) {
        array_push($masters_arr, $master[0]);
    }
    if (count($masters_arr) != 0)
        $masters_str = join(',', $masters_arr);

   
    array_push($data, [
        "id" => $service[0],
        "title" => $service[1],
        "masters" => $masters_str,
        "price" => $service[3],
    ]);

}



echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>