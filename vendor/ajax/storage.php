<?php
session_start();
require_once '../../blocks/models.php';

use Models\Material;
$data = Material::MaterialsOnStorage();



$res_data = [
    "data" => $data
];
echo json_encode($res_data, JSON_UNESCAPED_UNICODE);
?>