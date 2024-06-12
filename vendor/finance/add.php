<?php 

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

 

$type=$_POST['type'];
$date=$_POST['date'];
$category=$_POST['category'];
$sum=$_POST['sum'];

$query="INSERT INTO `fin_data`(`type`, `date`,`category`,`sum`) VALUES ('$type','$date','$category','$sum')";
echo $query;
$res=Query::query($query);

header('Location: ../../pages/financial_accounting.php');
