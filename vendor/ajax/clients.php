
<?php
session_start();
require_once '../../blocks/models.php';

use Models\Client;
use Models\Master;
use Models\Service;
$clients = Client::ClientsFull();
if ($_SESSION['user']['master_id'] != null)
    $clients = Client::ClientsFullByMaster($_SESSION['user']['master_id']);

$res = [];
if (!is_null($clients[0][0])&&$clients != []) {
    foreach ($clients as $client) {
        $masters = Master::MastersByClient($client[0]);
        $services = Service::ServicesByClient($client[0]);
        $ms = [];
        $ss = [];
        foreach ($masters as $m) {
            array_push($ms, $m[1]);
        }
        foreach ($services as $s) {
            array_push($ss, $s[1]);
        }
        $masters_str=join(', ', $ms);
        $services_str=join(', ', $ss);
        array_push($res, [
            "id" => $client[0],
            "full_name" => "$client[1]",
            "date_of_birth" => "$client[2]",
            "phone" => "$client[3]",
            "email" => "$client[4]",
            "telegram" => "$client[5]",
            "instagram" => "$client[6]",
            "seanses_number" => "$client[7]",
            "masters" => $masters_str,
            "services" =>  $services_str,
        ]);
    }
}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
