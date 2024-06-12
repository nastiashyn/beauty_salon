<?php

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

Query::Delete("employee", 'id', $_GET['id']);
Query::Delete("employers_services", 'employer_id', $_GET['id']);
$res = [
    'message' => "Deleted master #" . $_GET['id'],
];


header('Location: ../../pages/masters.php');

