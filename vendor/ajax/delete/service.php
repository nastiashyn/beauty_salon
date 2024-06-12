<?php
require_once '../../../blocks/models.php';
use Models\Query;

Query::Delete("seans_services", 'service_id', $_GET['id']);
Query::Delete("service_materials", 'service_id', $_GET['id']);
Query::Delete("employers_services", 'service_id', $_GET['id']);
Query::Delete("services", 'id', $_GET['id']);
$res = [
    'message' => "Deleted item #" . $_GET['id'],
];

echo json_encode($res, JSON_UNESCAPED_UNICODE);

