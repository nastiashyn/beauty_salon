<?php
use Models\Query;

session_start();

require_once '../../blocks/models.php';
$connect = Query::DB();
$full_name = $_POST['full_name'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$password_confirm = $_POST['password_confirm'];

if ($password === $password_confirm) {

    $password = md5($password);

    mysqli_query($connect, "INSERT INTO `users` ( `full_name`, `login`, `email`, `password`,`role`) VALUES ('$full_name', '$login', '$email', '$password','$role')");

    $_SESSION['message'] = 'Реєстрація пройшла успішно!';
    header('Location: ../../pages/main.php');


} else {
    $_SESSION['message'] = 'Паролі не співпадають';
    header('Location: ../../auth/register.php');
}

?>