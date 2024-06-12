<?php 



require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;


for($i=1;$i<=10;$i++){
    $name="new item" . $i;
    $description="some text";
    $res=mysqli_query($db, "INSERT INTO `items`(`name`, `description`) VALUES ('$name','$description')");

}



header('Location: ../index.php');
