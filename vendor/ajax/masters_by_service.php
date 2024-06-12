<?php
session_start();
require_once '../../blocks/models.php';
use Models\Master;


$id = $_GET["id"];
$masters = Master::MastersByService($id);
if ($id == 0)
    $masters = Master::Masters();
$res = [];
foreach ($masters as $master) {
    array_push($res, [
        "id" => $master[0],
        "name" => $master[1]
    ]);
}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>