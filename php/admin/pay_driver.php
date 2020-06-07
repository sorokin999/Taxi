<?php

include '../connect.php';

$n = (int) $_POST['key'];
$b = false;
$nalog = (int)mysqli_query($link,"SELECT nalog FROM voditel WHERE id_user = $n")->fetch_all(MYSQLI_ASSOC)[0]['nalog'];

$bank_id = (int)mysqli_query($link,"SELECT id FROM bank ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC)[0]['id'];
$bank_current = (int)mysqli_query($link,"SELECT sum_bank FROM bank WHERE id = $bank_id")->fetch_all(MYSQLI_ASSOC)[0]['sum_bank'];

$bank_current += $nalog;

date_default_timezone_set('Asia/Yekaterinburg');
$d = date("Y-m-d") . " " . date("H:i:s");

$insert = mysqli_query($link,"INSERT INTO bank (sum_bank,sum_gain,sum_lose,time_operation)
VALUES (
    $bank_current,
    $nalog,
    0,
    '$d'
)");

if($insert)
{
    $update = mysqli_query($link,"UPDATE voditel
    SET nalog = 0
    WHERE id_user = $n");
    if ($update){
        $b=true;
        echo($b);
        exit();
    }
    else
    {
        echo mysqli_error($link);
        exit();
    }
}