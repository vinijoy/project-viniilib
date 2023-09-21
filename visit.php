<?php
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control:no-cashe");
header("Pragma:no-cashe");
include ("./inc/var.php");
$visit_count = array();
$avisit_count_sql = "select sum(visit_count)
from visit_count
where visit_level=0";
$result = mysqli_query($conn, $avisit_count_sql);
$row = mysqli_fetch_array($result);
$avisitor = $row[0];

$tvisit_count_sql = "select sum(visit_count)
from visit_count
where visit_d='{$today}'
and visit_level=0";
$result = mysqli_query($conn, $tvisit_count_sql);
$row = mysqli_fetch_array($result);
$tvisitor = $row[0];

        $array_row['avisitor'] = $avisitor;
        $array_row['tvisitor'] = $tvisitor;
        array_push($visit_count, $array_row);
$json_data = json_encode($visit_count);
echo urldecode($json_data);
?>
