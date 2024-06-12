<?php
namespace Models;
class Query
{
    private static $db;
    public static function DB()
    {
        $par1_ip = "127.0.0.1";
        $par2_name = 'root';
        $par3_p = '';
        $par4_dp = 'crm';

        $db = mysqli_connect($par1_ip, $par2_name, $par3_p, $par4_dp);

        mysqli_set_charset($db, 'utf8');
        if (!$db) {
            echo "error";
        }
        return $db;
    }
    static function Insert($table_name, $data)
    {
        $keys = implode(", ", array_keys($data));
        $update_values = '';
        foreach ($data as $key => $value) {
            $update_values .= "'$value', ";
        }
        $update_values = rtrim($update_values, ', '); // Видаляємо останню кому
        $query = "INSERT INTO `$table_name` ($keys) VALUES ($update_values)";
        self::query($query);
        return self::last_item_id($table_name);
    }
    static function Delete($table_name, $column, $item_id)
    {
        return mysqli_query(self::DB(), "DELETE FROM `$table_name` WHERE $column=$item_id");
    }
    static function Update($table_name, $data, $condition_column, $condition_value)
    {
        // Формуємо частину запиту для оновлення
        $update_values = '';
        foreach ($data as $key => $value) {
            $update_values .= "`$key` = '$value', ";
        }
        $update_values = rtrim($update_values, ', '); // Видаляємо останню кому

        // Формуємо частину запиту для умови
        $condition = "`$condition_column` = $condition_value";

        // Формуємо основний запит
        $query = "UPDATE `$table_name` SET $update_values WHERE $condition";

        self::query($query);
    }
    static function last_item_id($table_name)
    {
        return mysqli_fetch_all(mysqli_query(self::DB(), "SELECT MAX(id) FROM`$table_name`"))[0][0];
    }
    static function Select(string $query)
    {
        //echo $query;
        return mysqli_fetch_all(self::query($query));
    }
    static function SelectItem(string $query)
    {
        return mysqli_fetch_assoc(self::query($query));
    }
    static function SelectFromTable(string $table)
    {
        return mysqli_fetch_all(self::query("SELECT * FROM $table;"));
    }
    static function query(string $query)
    {
        $res = mysqli_query(self::DB(), $query);

        return $res;
    }

    
    
    
}