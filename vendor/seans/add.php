<?php
session_start();

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;


$client_id = $_SESSION["user"]["client_id"] != null ? $_SESSION["user"]["client_id"] : $_POST['client_id'];
$date = $_POST['date'];

$service_ids = $_POST['service_ids'];

$seans_id = Query::Insert('seans', [
   'client_id' => $client_id,
   'date' => $date,
]);
foreach ($service_ids as $service_id) {
   Query::Insert('seans_services', [
      'service_id' => $service_id,
      'seans_id' => $seans_id,
   ]);
}


header('Location: ../../pages/entry_schedule.php');
