<?php
session_start();
require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;
if (isset($_POST["login"])) {
   Query::Update("clients", [
      'full_name' => $_POST['full_name'],
      'login' => $_POST['date_of_birth'],
      'email' => $_POST['email'],
   ], "id", $_SESSION["user"]["id"]);
   if (isset($_POST["instagram"])) {
      Query::Update("clients", [
         'full_name' => $_POST['full_name'],
         'date_of_birth' => $_POST['date_of_birth'],
         'phone' => $_POST['phone'],
         'email' => $_POST['email'],
         'telegram' => $_POST['telegram'],
         'instagram' => $_POST['instagram'],
      ], "id", $_SESSION["user"]["client_id"]);
   } else if (isset($_POST["status"])) {
      Query::Update("clients", [
         'full_name' => $_POST['full_name'],
         'phone' => $_POST['phone'],
         'status' => $_POST['status']
      ], "id",  $_SESSION["user"]["master_id"]);
   }
} else if (isset($_POST["instagram"])) {
   Query::Insert('clients', [
      'full_name' => $_POST['full_name'],
      'date_of_birth' => $_POST['date_of_birth'],
      'phone' => $_POST['phone'],
      'email' => $_POST['email'],
      'telegram' => $_POST['telegram'],
      'instagram' => $_POST['instagram'],
   ]);
   //print_r(Query::last_item_id("clients"));
   Query::Update("users", [
      'client_id' => Query::last_item_id("clients"),
   ], "id", $_SESSION["user"]["id"]);
   $_SESSION["user"]["client_id"]=Query::last_item_id("clients");
} else if (isset($_POST["status"])) {
   Query::Insert('employee', [
      'full_name' => $_POST['full_name'],
      'phone' => $_POST['phone'],
      'status' => $_POST['status']
   ]);
   Query::Update("users", [
      'master_id' => Query::last_item_id("employee"),
   ], "id", $_SESSION["user"]["id"]);
   $_SESSION["user"]["master_id"]=Query::last_item_id("employee");
}
header('Location: ../../pages/main.php');