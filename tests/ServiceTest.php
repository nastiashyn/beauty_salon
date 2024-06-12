<?php
require_once "C:\Users\Julie\source\beauty_salon\blocks\models.php";
// tests/ServiceTest.php
use Models\FinanseData;
use Models\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase {
    public function test1() {
        
        $dates = FinanseData::min_and_max_dates();
        $result = Service::TopServicesByPeriod($dates[0][0],$dates[0][1]);
        $expected_result=[["Фарбування волосся","3","152.25"],["Манікюр","2","80"],
        ["Догляд за волоссям","1","70"],["Парафінотерапія","2","70"],["Гігієнічне очищення","1","55"]];
        $this->assertEquals($expected_result, $result);
    }
}


