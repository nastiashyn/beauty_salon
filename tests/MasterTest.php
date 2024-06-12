<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
// tests/ServiceTest.php
use Models\Master;
use PHPUnit\Framework\TestCase;

class MasterTest extends TestCase {
    public function test1() {
        
        $result = Master::MastersByService(4);
        $expected_result=[["4","Ірина Коваленко","+380991234585","працює","2800"]];
        $this->assertEquals($expected_result, $result);
    }
}
