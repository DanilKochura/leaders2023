<?php
global $route;
require_once ROOT.'/model/DB.php';
require_once ROOT.'/views/inc/header.php';
$alphabet = range("A", "Z");

if($route[0] == '/')
{

    require_once ROOT.'/views/index.php';
    require_once ROOT.'/views/inc/footer.php';
} else
{
    $_POST =
        [
          'flight' => 1130,
          'from' => 'SVO',
          'to' => 'AER',
          'date' => '2018-09-03'
        ];
    $resp = [];
    $db = new DB();
    $query = "SELECT * from class where flt_num = '{$_POST['flight']}' and `dd` = '{$_POST['date']}' AND `sorg` = '{$_POST['from']}' AND `sdst` = '{$_POST['to']}'";
    if($_POST['class'])
    {
        $query.="and `seg_class_code` = '{$_POST['class']}'";
    }
    $res = $db->conn->query($query);
    if($res->num_rows == 0)
    {
        die(json_encode([]));
    }
    $i = 0;
    while($row = $res->fetch_assoc())
    {
        $resp['count'] = $res->num_rows;
        $resp['data'][$row['seg_class_code']]['dates'][$i] = $row['sdat_s'];
        $resp['data'][$row['seg_class_code']]['pass'][$i] = $row['pass_bk'];
        if(isset($resp['pass'][$i-1]))
        {
            $resp['data'][$row['seg_class_code']]['pass'][$i-1] -= $row['pass_bk'];
        }
        $i++;
    }
    echo json_encode($resp);
    die();
}

