<?php
session_start();

require_once '../../blocks/models.php';
use Models\Seanse;
use Models\Service;


$startDate = date('Y-m-d', strtotime($_GET["start"] . ' + 1 days'));
$endDate = date('Y-m-d', strtotime($_GET["end"] . ' - 1 days'));
$param = "default";
$param_value = "";
if ($_SESSION['user']['client_id']!=null) {
    $param = "client";
    $param_value = $_SESSION['user']['client_id'];
} else if ($_SESSION['user']['master_id']!=null) {
    $param = "master";
    $param_value = $_SESSION['user']['master_id'];
}
$seanses = Seanse::Seanses($startDate, $endDate, $param,$param_value);

$data = [];
foreach ($seanses as $seans) {
    $clientName = $seans[2];
    $clientPhone = $seans[3];
    $sessionStart = date('Y-m-d H:i', strtotime($seans[1]));
    //calc
    $sessionEnd = null;

    $minutesToAdd = 0;
    $sessionTotal = 0;
    $mastersNames = array();
    $services_ = Service::ServicesBySeans($seans[0]);
    $services = [];

    foreach ($services_ as $service) {
        $sessionTotal = $sessionTotal + $service[3];
        $minutesToAdd = $minutesToAdd + $service[4];
        array_push($services, [
            "id" => $service[0],
            "title" => $service[1],
            "description" => $service[2],
            "price" => $service[3],
            "time" => $service[4],
            "masterId" => $service[5],
            "masterName" => $service[6]
        ]);
        array_push($mastersNames, $service[6]);
    }
    $sessionEnd = date('Y-m-d H:i', strtotime($sessionStart . ' + ' . $minutesToAdd . ' minutes'));
//echo $sessionEnd;
    $masterName = join(", ", $mastersNames);
    array_push($data, [
        "title" => "" . $seans[4] . " (" . $seans[2] . ")",
        "start" => $sessionStart,
        "end" => $sessionEnd,
        "extendedProps" => [
            "title" => "$seans[1]",
            "id" => $seans[0],
            "start" => date('d.m H:i', strtotime($seans[1])),
            "end" => $sessionEnd,
            "clientName" => $clientName,
            "clientPhone" => $clientPhone,
            "sessionStart" => $sessionStart,
            "sessionEnd" => $sessionEnd,
            "masterName" => $masterName,
            "sessionTotal" => $sessionTotal,
            "servicesList" => $services
        ],
    ]);
}



echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>