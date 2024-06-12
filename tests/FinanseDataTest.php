<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
// tests/ServiceTest.php
use Models\FinanseData;
use Models\Service;
use PHPUnit\Framework\TestCase;

class FinanseDataTest extends TestCase {
    public function test1() {
        $result = FinanseData::min_and_max_dates();
        $expected_result=[["2024-04-01 00:00:00","2024-05-15 15:45:00"]];
        $this->assertEquals($expected_result, $result);
    }
}
