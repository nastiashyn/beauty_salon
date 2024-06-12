<?php
session_start();
require_once '../../blocks/models.php';
use Models\Master;
use Models\Query;
use Models\Service;
use function Models\query;



$searchWord = $_GET["searchword"];
$masters = Master::Masters($searchWord);
$res = [];
foreach ($masters as $master) {
    $services = Service::ServicesByMastersOnlyName($master[0]);
    $services_list = [];
    foreach ($services as $service) {
        array_push($services_list, $service[1]);
    }
    $query = "SELECT SUM(serv.price) FROM employee as e JOIN employers_services as es ON es.employer_id=e.id JOIN services as serv ON serv.id=es.service_id JOIN seans_services sserv ON sserv.service_id=serv.id JOIN seans as s ON s.id=sserv.seans_id WHERE e.id=$master[0];";
    $profit_from_seanses = Query::Select($query)[0][0];
    array_push($res, [
        "id" => $master[0],
        "full_name" => $master[1],
        "phone" => $master[2],
        "services" => $services_list,
        "status" => $master[3],
        "salary" => $master[4],
        "profit_from_seanses" => $profit_from_seanses,
    ]);

}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>