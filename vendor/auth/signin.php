<?php

session_start();
require_once '../../blocks/models.php';
use Models\Query;
$connect = Query::DB();
$login = $_POST['login'];
$password = md5($_POST['password']);

//echo "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
print_r($check_user);
if (mysqli_num_rows($check_user) > 0) {

    $user = mysqli_fetch_assoc($check_user);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "full_name" => $user['full_name'],
        "login" => $user['login'],
        "role" => $user['role'],
        "email" => $user['email'],
        "client_id" => $user['client_id'],
        "master_id" => $user['master_id'],
    ];
    header('Location: ../../pages/main.php');

} else {
    $_SESSION['message'] = 'Не вірний логін або пароль';
    header('Location: ../../auth/main.php');
}
?>