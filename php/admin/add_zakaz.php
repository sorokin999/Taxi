<?php

foreach ($_POST as $item) {
    if (empty($item)) {
        echo ('Ошибка');
        exit();
    }
}

include '../connect.php';

$otkuda = $_POST['otkuda'];
$kuda = $_POST['kuda'];
$rass = $_POST['rass'];
$price = (int) $_POST['price'];
$client = $_POST['client'];

$rass = substr($rass, strpos($rass, ' '), 10);
date_default_timezone_set('Asia/Yekaterinburg');
$d = date("Y-m-d") . " " . date("H:i:s");

$comission = (int) mysqli_query($link, "SELECT comission FROM tarif")->fetch_all(MYSQLI_ASSOC)[0]['comission'];
$dohod = $price / 100 * $comission;

$q = mysqli_query($link, "INSERT INTO zakaz (
    location_1,
    location_2,
    price,
    status,
    data,
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
    '$client',
    '$rass',
    $dohod
)
");

if ($q) {
    echo 'OK';
} else {
    echo (mysqli_error($link));
}

/*
array(5) {
["otkuda"]=>
string(13) "новая 10"
["kuda"]=>
string(12) "армада"
["rass"]=>
string(28) "Расстояние: 5 км"
["price"]=>
string(3) "120"
["client"]=>
string(12) "+79325512487"
}
*/