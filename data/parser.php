<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', '../web');
require_once '../web/model/DB.php';
$db = new DB();

//region Classes
$db->conn->query(file_get_contents('create_class_table.sql'));
$db->conn->query(file_get_contents('alter_class_table.sql'));
$db->conn->query(file_get_contents('primary_class_table.sql'));
$str = "INSERT INTO `class`(`sdat_s`, `sak`, `flt_num`, `dd`, `seg_num`, `sorg`, `sdst`, `sscl1`, `seg_class_code`, `nbcl`, `fclcld`, `pass_bk`, `sa`, `au`, `pass_dep`, `ns`, `dtd`) VALUES ";
$row = 0;
$files = scandir('class');
foreach ($files as $f)
{
    $i = 0;
    $q = $str;
    if(!file_exists('class/'.$f))
    {
        continue;
    }
    if (($handle = fopen('class/'.$f, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ";");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {


            if(in_array($data[2], [1122, 1123,1140])) //in_array($data[2], [1117, 1123, 1122, 1790, 1130, 1173, 1140])
            {
                $data[0] = date('Y-m-d', strtotime($data[0]));
                $data[3] = date('Y-m-d', strtotime($data[3]));

                $q.='("' . implode('","', $data) . '"),';
            } else
            {
                continue;
            }
            if($i++ == 10000)
            {
                $i = 0;
                echo $row.PHP_EOL;
                $q = rtrim($q, ',');
                $db->conn->query($q);
                $q = $str;
            }
            $row++;



        }
        fclose($handle);
        echo 'ended';
    }

}
//endregion

//region Rasp
$db->conn->query(file_get_contents('create_rasp_table.sql'));
$db->conn->query(file_get_contents('alter_rasp_table.sql'));
$db->conn->query(file_get_contents('primary_rasp_table.sql'));
$row = 0;
$str = "INSERT INTO `rasp`(`ak`, `flt_numsh`, `leg_org`, `leg_dest`, `effv_date`, `disc_date`, `freq`, `num_legs`, `capture_date1`, `dep_time1`, `arr_time1`, `equip1`) VALUES ";

$files = scandir('rasp');
foreach ($files as $f)
{
    $i = 0;
    $q = $str;
    if(!file_exists('rasp/'.$f))
    {
        continue;
    }
    if (($handle = fopen('rasp/'.$f, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ";");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

            $data[4] = date('Y-m-d', strtotime($data[4]));
            $data[5] = date('Y-m-d', strtotime($data[5]));
            $data[8] = date('Y-m-d', strtotime($data[8]));

            $q.='("' . implode('","', $data) . '"),';

            if($i++ == 10000)
            {
                $i = 0;
                echo $row.PHP_EOL;
                $q = rtrim($q, ',');
                $db->conn->query($q);
                $q = $str;
            }
            $row++;



        }
        fclose($handle);
        echo 'ended';
    }

}
//endregion
