<?php

foreach ($_POST as $item) {
    if (empty($item)) {
        echo ('Сначала нужно рассчитать стоимость');
        exit();
    }
}

include 'connect.php';
session_start();
$otkuda = $_POST['otkuda'];
$kuda = $_POST['kuda'];
$rass = $_POST['rass'];
$client = (int)$_SESSION['id'];
$price = (int) $_POST['price'];

$rass = substr($rass, strpos($rass, ' '), 10);
date_default_timezone_set('Asia/Yekaterinburg');
$d = date("Y-m-d") . " " . date("H:i:s");

$phone = mysqli_query($link,"SELECT phone FROM user WHERE id = $client")->fetch_all(MYSQLI_ASSOC)[0]['phone'];

$comission = (int) mysqli_query($link, "SELECT comission FROM tarif")->fetch_all(MYSQLI_ASSOC)[0]['comission'];
$dohod = $price / 100 * $comission;

$q = mysqli_query($link, "INSERT INTO zakaz (
    location_1,
    location_2,
    price,
    status,
    data,
    id_user,
    user_phone,
    distance,
    dohod
)
VALUES(
    '$otkuda',
    '$kuda',
    $price,
    3,
    '$d',
    $client,
    '$phone',
    '$rass',
    $dohod
)
");

if ($q) {
    echo 'OK';
} else {
    echo (mysqli_error($link));
}

/**array(4) {
["otkuda"]=>
string(10) "север"
["kuda"]=>
string(12) "армада"
["rass"]=>
string(28) "Расстояние: 2 км"
["price"]=>
string(2) "90"
} */