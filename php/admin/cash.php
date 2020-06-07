<?php

$cash = (int) $_POST['sum'];
$b = false;

if ($cash == 0)
    echo "Некорректные данные";
else {
    include '../connect.php';
    $bank_id = (int) mysqli_query($link, "SELECT id FROM bank ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC)[0]['id'];
    $bank_current = (int) mysqli_query($link, "SELECT sum_bank FROM bank WHERE id = $bank_id")->fetch_all(MYSQLI_ASSOC)[0]['sum_bank'];

    $bank_current -= $cash;
    date_default_timezone_set('Asia/Yekaterinburg');
    $d = date("Y-m-d") . " " . date("H:i:s");

    $insert = mysqli_query($link, "INSERT INTO bank (sum_bank,sum_gain,sum_lose,time_operation)
VALUES (
    $bank_current,
    0,
    $cash,
    '$d'
)");
    if ($insert)
        $b = true;
    echo $b;
}