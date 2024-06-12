<?php

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

Query::Insert('materials', [
   'title' => $_POST['title'],
   'description' => $_POST['description'],
   'material_price' => $_POST['material_price'],
   'number_for_price' => $_POST['number_for_price'],
   'unit' => $_POST['unit'],
   'days_number_expiration' => $_POST['days_number_expiration'],
]);

header('Location: ../../pages/scklad.php');