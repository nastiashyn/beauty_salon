<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
use Models\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
    public function test1() {
        
        $result=Client::Client(4);
        $expected_result=["id"=>"4","full_name"=>"Юлія Коваленко",
        "date_of_birth"=>"1976-08-30","phone"=>"+380991234570",
        "email"=>"vasyl@example.com","telegram"=>"@vasyl_telegram","instagram"=>"@vasyl_instagram"];
        $this->assertEquals($expected_result, $result);
    }
}
