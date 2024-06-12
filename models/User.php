<?php


namespace Models;
use DateTime;
use Models\Client;

class User extends Client
{
    public $id;
    public $full_name;
    public $login;
    public $email;
    public $password;
    public $role;
    public $client_id;
    public $master_id;
    static public function Register(User $user){

    }
    static public function LogIn(User $user){

    }
}