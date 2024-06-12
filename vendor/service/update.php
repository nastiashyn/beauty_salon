<?php

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

Query::Update('services', [
   'name' => $_POST['name'],
   'price' => $_POST['price'],
   'description' => $_POST['description'],
   'time' => $_POST['time'],
],'id',$_GET['id']);

header('Location: ../../pages/services.php');
