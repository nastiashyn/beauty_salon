<?php


require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$salary = $_POST['salary'];

print_r($_POST);
$service_id = Query::Insert('employee', [
   'full_name' => $_POST['full_name'],
   'phone' => $_POST['phone'],
   'salary' => $_POST['salary'],
]);

header('Location: ../../pages/masters.php');
