<?php

$conn = new mysqli('localhost', 'root', 'Danil2002', 'u131898_hack');
if($conn->connect_error)
{
    die("Could't connect with database");
}
$str = "INSERT INTO `class`(`sdat_s`, `sak`, `flt_num`, `dd`, `seg_num`, `sorg`, `sdst`, `sscl1`, `seg_class_code`, `nbcl`, `fclcld`, `pass_bk`, `sa`, `au`, `pass_dep`, `ns`, `dtd`) VALUES ";
$row = 0;
$files = ['012018','022018','032018','042018','052018','062018','072018','082018','092018','102018','112018', '122018'];
foreach ($files as $f)
{
    $file = "sql/CLASS_".$f.'.sql';
    $i = 0;
    $q = $str;
    if (($handle = fopen('../data/CLASS_'.$f.'.csv', "r")) !== FALSE) {
        fgetcsv($handle, 1000, ";");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $row++;

            if($i++ == 10000)
            {
                $i = 0;
                echo $row.PHP_EOL;
                $q = rtrim($q, ',');
                $conn->query($q);
                $q = $str;
            }
            $data[0] = date('Y-m-d', strtotime($data[0]));
            $data[3] = date('Y-m-d', strtotime($data[3]));

            $q.='("' . implode('","', $data) . '"),';


        }
        fclose($handle);
        file_put_contents(__DIR__.'/log.txt', 'Ended '.date('Y-m-d H:i:s').' '.$f.PHP_EOL);
        echo 'ended';
    }

}