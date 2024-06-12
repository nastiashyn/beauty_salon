<?php 

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

$full_name=$_POST['full_name'];
$date_of_birth=$_POST['date_of_birth'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$telegram=$_POST['telegram'];
$instagram=$_POST['instagram'];

$res=mysqli_query(Query::DB(), "INSERT INTO `clients`(`full_name`, `date_of_birth`,`phone`,`email`,`telegram`,`instagram`) 
VALUES ('$full_name','$date_of_birth','$phone','$email','$telegram','$instagram')");

header('Location: ../../pages/customer_base.php');
