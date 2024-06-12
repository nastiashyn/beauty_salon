<?php
namespace Models;
$months = [
    '01' => 'січень',
    '02' => 'лютий',
    '03' => 'березень',
    '04' => 'квітень',
    '05' => 'травень',
    '06' => 'червень',
    '07' => 'липень',
    '08' => 'серпень',
    '09' => 'вересень',
    '10' => 'жовтень',
    '11' => 'листопад',
    '12' => 'грудень',
];
function is_registered()
{
    if (isset($_SESSION['user']))
        return true;
    else
        return false;
}
function checkRegistered()
{
    if (!is_registered()) {
        header('Location: ../auth/main.php');
    }
}
function checkNotRegistered()
{
    if (is_registered()) {
        header('Location: ../pages/main.php');
    }
}
function delete($db, $table_name, $item_id)
{
    return mysqli_query($db, "DELETE FROM `$table_name` WHERE id=$item_id");
}
function last_item_id($db, $table_name)
{
    return mysqli_fetch_all(mysqli_query($db, "SELECT MAX(id) FROM`$table_name`"))[0][0];
}
function query($db, string $query)
{
    return mysqli_fetch_all(mysqli_query($db, $query));
}
function select($db, $table_name)
{
    switch ($table_name) {
        case "masters_full":
            return mysqli_fetch_all(mysqli_query($db, "SELECT * FROM employee"));
        default:
            return mysqli_fetch_all(mysqli_query($db, "SELECT * FROM `$table_name` "));
    }
}


