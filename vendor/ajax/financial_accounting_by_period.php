<?php
require_once '../../blocks/models.php';
use Models\Client;
use Models\FinanseData;
use Models\Master;
use Models\Service;



$first_date = date("Y-m-d", strtotime($_GET['date1']));
$last_date = date("Y-m-d", strtotime($_GET['date2']));
FinanseData::DataByPeriod($first_date, $last_date);
$date1 = strtotime($first_date);
$date2 = strtotime($last_date);
$days = round(($date2 - $date1) / (60 * 60 * 24));
$groupBy = "";
if ($days <= (7 * 8))
    $groupBy = "1 week";
else if ($days <= (122))
    $groupBy = "2 week";
else if ($days <= (244))
    $groupBy = "1 month";
else if ($days <= (61 * 8))
    $groupBy = "2 months";
else if ($days <= (122 * 8))
    $groupBy = "1 qvartal";
else if ($days <= (365 * 8))
    $groupBy = "6 months";
else if ($days > (365 * 8))
    $groupBy = "1 year";
else
    $groupBy = "1 day";

$data = [];
$current_date1 = $first_date;
while (strtotime($current_date1) <= strtotime($last_date)) {
    //вибрати дані по проміжку
    //виправлення умов для визначення періодів
    switch ($groupBy) {
        case "1 week":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 6 days'));
            break;
        case "2 week":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 13 days'));
            break;
        case "1 month":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 29 days'));
            break;
        case "2 months":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 59 days'));
            break;
        case "1 quarter":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 89 days'));
            break;
        case "6 months":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 179 days'));
            break;
        case "1 year":
            $current_date2 = date("Y-m-d", strtotime($current_date1 . ' + 364 days'));
            break;
        case "1 day":
            $current_date2 = $current_date1;
            break;
    }

    // Перевірка для останнього періоду
    if (strtotime($current_date2) > strtotime($last_date)) {
        $current_date2 = $last_date;
    }
    $materials = 0;
    $salary = 0;
    $seanses = 0;
    $rent = 0;
    $utilities = 0;
    $others_income = 0;
    $others_expences = 0;
    $data_ = FinanseData::DataByPeriod($current_date1, $current_date2);
    if (count($data_) != 0) {
        for ($i = 0; $i < count($data_); $i++) {
            if ($data_[$i][2] == "materials")
                $materials += $data_[$i][1];
            else if ($data_[$i][2] == "salary")
                $salary += $data_[$i][1];
            else if ($data_[$i][2] == "services")
                $seanses += $data_[$i][1];
            else if ($data_[$i][2] == "rent")
                $rent += $data_[$i][1];
            else if ($data_[$i][2] == "utilities")
                $utilities += $data_[$i][1];
            else {

                if ($data_[$i][3] == "дохід")
                    $others_income += $data_[$i][1];
                else
                    $others_expences += $data_[$i][1];
            }
        }
    }
    //print_r(json_encode($data_));
    $newdata = [
        "date_1" => $current_date1,
        "date_2" => $current_date2,
        "materials" => $materials,
        "salary" => $salary,
        "seanses" => $seanses,
        "rent" => $rent,
        "utilities" => $utilities,
        "others_income" => $others_income,
        "others_expences" => $others_expences,
        "_income" => 0,
        "_expenses" => 0,
        "_profit" => 0,
    ];
    array_push($data, $newdata);
    switch ($groupBy) {
        case "1 week":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 7 days'));
            break;
        case "2 week":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 14 days'));
            break;
        case "1 mounth":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 30 days'));
            break;
        case "2 mounths":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 61 days'));
            break;
        case "1 qvartal":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 122 days'));
            break;
        case "6 mounths":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 183 days'));
            break;
        case "1 year":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 365 days'));
            break;
        case "1 day":
            $current_date1 = date("Y-m-d", strtotime($current_date1 . ' + 1 days'));
            break;
    }
}
//топ-клієнтів, майстрів та послуг
//отримати дані і сформувати в json, можна навіть без циклу, і вручну по 5 значень
$top_clients_data = Client::TopClientsByPeriod($first_date, $last_date);
$top_services_data = Service::TopServicesByPeriod($first_date, $last_date);
$top_masters_data = Master::TopEmployeeByPeriod($first_date, $last_date);
$top_clients = [];
$top_services = [];
$top_masters = [];
for ($i = 0; $i < 5; $i++) {
    array_push($top_clients, ["id" => $i + 1, "name" => $top_clients_data[$i][0], "seanses" => $top_clients_data[$i][1], "profit" => $top_clients_data[$i][2]]);
    array_push($top_services, ["id" => $i + 1, "name" => $top_services_data[$i][0], "seanses" => $top_services_data[$i][1], "profit" => $top_services_data[$i][2]]);
    array_push($top_masters, ["id" => $i + 1, "name" => $top_masters_data[$i][0], "seanses" => $top_masters_data[$i][1], "profit" => $top_masters_data[$i][2]]);
}
//print_r($top_services_data);

$res = [
    'data' => $data,
    'groupBy' => $groupBy,
    'tops' => [
        'top_clients' => $top_clients,
        'top_services' => $top_services,
        'top_masters' => $top_masters,
    ],
];

echo json_encode($res, JSON_UNESCAPED_UNICODE);