<?php
session_start();
require_once '../../blocks/models.php';
use Models\FinanseData;



$query_res = FinanseData::min_and_max_dates();
//отримати весь період і повернути найпершу і останню дату
$min_date = $query_res[0][0];
$max_date = $query_res[0][1];
$res = [
    'min_date' => $min_date,
    'max_date' => $max_date,
];

echo json_encode($res);