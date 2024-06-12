<?php
session_start();
require_once '../../blocks/models.php';
use Models\Material;
use Models\Query;



$id=$_GET["id"];
$unit=Query::Select("SELECT unit FROM materials WHERE id=$id")[0];
$res = [
    "unit"=>$unit
];


echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>