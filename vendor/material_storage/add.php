<?php

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

for ($i = 0; $i <= $_POST["number"]; $i++) {
   Query::Insert('materials_in_storage', [
      'material_id' => $_POST['material_id'],
      'date' => $_POST['date'],
   ]);
}

header('Location: ../../pages/scklad.php');