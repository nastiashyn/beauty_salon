<?php
require_once 'models/Query.php';
require_once 'models/User.php';

use Models\Services;

$data=Service::Services();

print_r($data);