<?php


require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

$master_id = $_GET['id'];

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$salary = $_POST['salary'];
$services_ids = $_POST['services_ids'];


Query::Update('employee', [
   'full_name' => $_POST['full_name'],
   'phone' => $_POST['phone'],
   'salary' => $_POST['salary'],
], 'id', $master_id);

//todo update services
Query::Delete('employers_services', 'employer_id', $master_id);
foreach ($services_ids as $service_id) {
   Query::Insert('employers_services', [
      "employer_id" => $master_id,
      "service_id" => $service_id
   ]);
}


header('Location: ../../pages/masters.php');
