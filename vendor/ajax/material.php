<?php
session_start();
require_once '../../blocks/models.php';
use Models\Query;



$id = $_GET["id"];
$item = Query::SelectItem("SELECT * FROM materials WHERE id=$id");
$res = [
    "id" => $item["id"],
    "title" => $item["title"],
    "unit" => $item["unit"],
];


echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>