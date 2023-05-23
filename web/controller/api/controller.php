<?php
require_once ROOT.'model/DB.php';


global $route;



if($route[1] == 'demand')
{
    $resp = [];
    $db = new DB();
    $res = $db->conn->query("SELECT * from class where flt_num = '{$_POST['flight']}' and `dd` = '{$_POST['date']}' AND `sorg` = '{$_POST['from']}' AND `sdst` = '{$_POST['to']}' and `seg_class_code` = '{$_POST['class']}' and datediff(dd, sdat_s) < 30");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }
    while($row = $res->fetch_assoc())
    {
        $resp['dates'][] = $row['sdat_s'];
        $resp['pass'][] = $row['pass_bk'];
    }
    echo json_encode($resp);

}
