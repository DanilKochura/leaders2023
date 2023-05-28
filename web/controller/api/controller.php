<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);
require_once ROOT.'model/DB.php';


global $route;

$db = new DB();


if($route[1] == 'demand')
{
    $resp = [];

    $res = $db->conn->query("SELECT * from class where flt_num = '{$_POST['flight']}' and `dd` = '{$_POST['date']}' AND `sorg` = '{$_POST['from']}' AND `sdst` = '{$_POST['to']}' and `seg_class_code` = '{$_POST['class']}' order by sdat_s ");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }

    $i = 0;
    $resp['count'] = $res->num_rows;
    while($row = $res->fetch_assoc())
    {
        $resp['dates'][$i] = $row['sdat_s'];
        $resp['pass'][$i] = $row['pass_bk'];
        $resp['pass_sqrt'][$i] = $row['pass_bk'];
        $resp['pass_div'][$i] = $row['pass_bk'];
        $resp['pass_def'][$i] = $row['pass_bk'];
        if(isset($resp['pass_sqrt'][$i-1]))
        {
            $resp['pass_sqrt'][$i-1] = sqrt(pow($row['pass_sqrt'] - $resp['pass_sqrt'][$i-1], 2)/2);
        }
        if(isset($resp['pass_def'][$i-1]))
        {
            $resp['pass_def'][$i] = $row['pass_bk'] - $resp['pass'][$i-1];
        }
        if(isset($resp['pass_div'][$i-1]))
        {
            $resp['pass_div'][$i-1] = $resp['pass_div'][$i]/$resp['pass_div'][$i-1];
        }
        $i++;

        $resp['label'] = $row['seg_class_code'];
    }
    echo json_encode($resp);
} elseif($route[1] == 'seasons')
{
    $resp = [];

    $res = $db->conn->query("SELECT * from class where flt_num = '{$_POST['flight']}' and `sorg` = '{$_POST['from']}' AND `sdst` = '{$_POST['to']}' and `seg_class_code` = '{$_POST['class']}' and year(dd) = '{$_POST['year']}' and dtd = -1  order by dd");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }

    $i = 0;
    $resp['count'] = $res->num_rows;
    while($row = $res->fetch_assoc())
    {
        $resp['dates'][$i] = $row['sdat_s'];
        $resp['pass'][$i] = $row['pass_bk'];
        $i++;

        $resp['label'] = $row['seg_class_code'];
    }
    echo json_encode($resp);
} elseif($route[1] == 'search_flight')
{
    $resp = [];

    $res = $db->conn->query("SELECT distinct flt_num from class where sorg = '{$_POST['from']}' and sdst = '{$_POST['to']}'");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }

    $i = 0;
    while($row = $res->fetch_assoc())
    {
        $resp[] = $row['flt_num'];
    }
    echo json_encode($resp);
}
