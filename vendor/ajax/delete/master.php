<?php
require_once '../../../blocks/models.php';
use Models\Query;

Query::Delete("employee", 'id', $_GET['id']);
Query::Delete("employers_services", 'employer_id', $_GET['id']);
$res = [
    'message' => "Deleted master #" . $_GET['id'],
];

echo json_encode($res, JSON_UNESCAPED_UNICODE);

