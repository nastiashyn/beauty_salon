<?php
session_start();
unset($_SESSION['user']);
header('Location: ../../auth/main.php');