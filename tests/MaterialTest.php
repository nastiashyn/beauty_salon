<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
// tests/ServiceTest.php
use Models\Material;
use PHPUnit\Framework\TestCase;

class MaterialTest extends TestCase {
    public function test1() {
        
        $result = Material::CheckMaterialsByService(3);
        $expected_result=false;
        $this->assertEquals($expected_result, $result);
    }
}



