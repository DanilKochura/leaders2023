<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);
require_once ROOT.'model/DB.php';


global $route;

$db = new DB();


function square_distance($array1, $array2)
{
    return sqrt(pow($array1[0]-$array2[0], 2)+ pow($array1[1]-$array2[1], 2)/2);
}


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
        $resp['pass_seasons'][$i] = $row['pass_bk'];
        $i++;

        $resp['label'] = $row['seg_class_code'];
    }
    $num = 15;

    $arr = $resp['pass_seasons'];
    $sum = 0;
    $co = count($arr);
    $diffs = [];
    $segments = [];
    for($i = 1; $i< $co; $i++)
    {
        $diffs[$i] = abs($arr[$i]-$arr[$i-1]);
    }
    arsort($diffs);
    $nodes =  array_slice(array_keys($diffs), 0, $num);
    sort($nodes);

    $segments = [];
    $j = 0;
    $dates = [0];
    for($i = 0; $i< $co; $i++)
    {
        if($i == $nodes[$j] and $j != $num - 1)
        {
            $segments[$j][] = $arr[$i];
            $dates[] = $i;
            $j++;
            $done = true;
            continue;
        }
        if(square_distance([$arr[$i], $i], [$arr[$nodes[$j]], $j]) > square_distance([$arr[$i], $i], [$arr[$nodes[$j-1]], $j-1]) and $done != false)
        {
            $segments[$j-1][] = $arr[$i];
        } else
        {
            $segments[$j][] = $arr[$i];
            $done = false;
        }
    }

    foreach($segments as $key1=>$seg)
    {
        $sum = 0;
        foreach($seg as $s)
        {
            $sum+=$s;
        }
        $avg = $sum/count($seg);
        foreach($seg as $key=>$s)
        {
            $segments[$key1][$key] = $avg;
        }
    }
    $resp['segments'] = $segments;
    $resp['segments_dates'] = $dates;
//    $resp['dates'] = $dates;
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
} elseif($route[1] == 'search_class')
{
    $resp = [];

    $res = $db->conn->query("SELECT distinct seg_class_code from class where flt_num =  '{$_POST['flight']}'");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }

    $i = 0;
    while($row = $res->fetch_assoc())
    {
        $resp[] = $row['seg_class_code'];
    }
    echo json_encode($resp);
}
