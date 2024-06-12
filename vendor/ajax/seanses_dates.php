<?php
session_start();


require_once '../../blocks/models.php';
use Models\Query;
use Models\Seanse;
use Models\Service;
//??
$param = "default";
$param_value = "";
if ($_SESSION['user']['client_id']!=null) {
    $param = "client";
    $param_value = $_SESSION['user']['client_id'];
} else if ($_SESSION['user']['master_id']!=null) {
    $param = "master";
    $param_value = $_SESSION['user']['master_id'];
}
$dates=Query::SelectItem("SELECT MIN(s.date) as min,MAX(s.date) as max FROM seans as s;");
$startDate=$dates['min'];
$endDate=$dates['max'];
$seanses = Seanse::Seanses($startDate, $endDate, $param,$param_value);

$data = [];

foreach ($seanses as $seans) {
    $clientName = $seans[2];
    $clientPhone = $seans[3];
    $sessionStart = date('Y-m-d H:i', strtotime($seans[1]));
    $sessionStartDate = date('Y-m-d', strtotime($seans[1]));
    $sessionStartTime = date('H:i', strtotime($seans[1]));
    //calc
    $sessionEnd = null;

    $minutesToAdd = 0;
    $sessionTotal = 0;
    $services_ = Service::ServicesBySeans($seans[0]);
    $services = [];

    foreach ($services_ as $service) {
        $sessionTotal = $sessionTotal + $service[3];
        $minutesToAdd = $minutesToAdd + $service[4];
        array_push($services, [
            "time" => $service[4],
        ]);
    }
    $sessionEnd = date('Y-m-d H:i', strtotime($sessionStart . ' + ' . $minutesToAdd . ' minutes'));
    $sessionEndDate = date('Y-m-d', strtotime($sessionStart . ' + ' . $minutesToAdd . ' minutes'));
    $sessionEndTime = date('H:i', strtotime($sessionStart . ' + ' . $minutesToAdd . ' minutes'));

//echo $sessionEnd;
    array_push($data, [
        "start" =>  $sessionStartDate . "T" . $sessionStartTime,
        "end" =>  $sessionEndDate . "T" . $sessionEndTime,
    ]);
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>