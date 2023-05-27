<?php
require_once ROOT.'model/DB.php';


global $route;



if($route[1] == 'demand')
{

    $resp = [];
    $db = new DB();
    $res = $db->conn->query("SELECT * from class where flt_num = '{$_POST['flight']}' and `dd` = '{$_POST['date']}' AND `sorg` = '{$_POST['from']}' AND `sdst` = '{$_POST['to']}' and `seg_class_code` = '{$_POST['class']}'");
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }
    $i = 0;
    while($row = $res->fetch_assoc())
    {
        $resp['count'] = $res->num_rows;
        $resp['dates'][$i] = $row['sdat_s'];
        $resp['pass'][$i] = $row['pass_bk'];
        if(isset($resp['pass'][$i-1]))
        {
            $resp['pass'][$i-1] -= $row['pass_bk'];
        }
        $i++;
        $resp['label'] = $row['seg_class_code'];
    }
    echo json_encode($resp);

} elseif($route[2] == 'flights')
{

}
