<?php
session_start();

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];


$material_ids = $_POST['materials'];
$numbers = $_POST['numbers'];

print_r($_POST);

$service_id = Query::Insert('services', [
   'name' => $_POST['name'],
   'price' => $_POST['price'],
   'description' => $_POST['description'],
   'time' => $_POST['time'],
]);
if ($_SESSION['user']['master_id'] == null) {
   $master_ids = $_POST['master_ids'];
   foreach ($master_ids as $master_id) {
      Query::Insert('employers_services', [
         'service_id' => $service_id,
         'employer_id' => $master_id,
      ]);
   }
} else {
   Query::Insert('employers_services', [
      'service_id' => $service_id,
      'employer_id' => $_SESSION['user']['master_id'],
   ]);
}

for ($i = 0; $i < count($material_ids); $i++) {
   Query::Insert('service_materials', [
      'service_id' => $service_id,
      'material_id' => $material_ids[$i],
      'number' => $numbers[$i],
   ]);
}

header('Location: ../../pages/services.php');
