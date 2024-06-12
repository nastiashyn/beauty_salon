<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
// tests/ServiceTest.php
use Models\Client;
use Models\FinanseData;
use Models\Master;
use Models\Material;
use Models\Service;

$result1=Client::Client(4);
$result2 = FinanseData::min_and_max_dates();
$result3 = Master::MastersByService(4);
$result4 = Material::CheckMaterialsByService(3);
$result5 = Service::TopServicesByPeriod($result2[0][0],$result2[0][1]);
$data=[
    "res1"=>$result1,
    "res2"=>$result2,
    "res3"=>$result3,
    "res4"=>$result4,
    "res5"=>$result5,

];
echo json_encode($data, JSON_UNESCAPED_UNICODE);
/*
vendor/bin/phpunit tests/ClientTest.php
vendor/bin/phpunit tests/FinanseDataTest.php
vendor/bin/phpunit tests/MasterTest.php
vendor/bin/phpunit tests/MaterialTest.php
vendor/bin/phpunit tests/ServiceTest.php

*/