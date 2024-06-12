<?php
session_start();

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php';
use Models\Query;

Query::Delete("users", 'id', $_SESSION['user']['id']);

header('Location: ../auth/logout.php');

