<?php

include '../connect.php';

$res = array([
    "status" => "Отладка",
    "text" => "ччч"
]);

if ($_POST['password'] != $_POST['password2']) {
    $res['status'] = "Ошибка";
    $res['text'] = "Пароли не совпадают";
    echo (json_encode($res));
    exit();
}

$super_pass = md5($_POST['password']);
$name = $_POST['name'];
$fam = $_POST['fam'];
$sur = $_POST['surname'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$p = (int) mysqli_query($link, "SELECT COUNT(*) as `kol` from user WHERE phone='$phone'")->fetch_all(MYSQLI_ASSOC)[0]['kol'];
if ($p > 0) {
    $res['status'] = "Ошибка";
    $res['text'] = "Номер занят, введите другой";
    echo (json_encode($res));
    exit();
}

$add_user = mysqli_query($link, "INSERT INTO user (name,surname,otch,phone,email,password,level) VALUES (
    '$name',
    '$fam',
    '$sur',
    '$phone',
    '$email',
    '$super_pass',
    2
)");

$new_driver_id = mysqli_insert_id($link);
$d = $_POST['data_prav'];
$d = substr($d, 6, 4) . "-" . substr($d, 3, 2) . "-" . substr($d, 0, 2);
$name_auto = $_POST['name_auto'];
$nomer_auto = $_POST['nomer_auto'];
$kuzov_auto = $_POST['kuzov_auto'];
$color_auto = $_POST['color_auto'];
$nomer_prav = $_POST['nomer_prav'];

$add_driver = mysqli_query($link, "INSERT INTO voditel 
(name_auto, 
nomer_auto, 
kuzov_auto, 
color_auto,
nomer_prav,
data_prav,
id_user,
status,
nalog)
VALUES(
    '$name_auto',
    '$nomer_auto',
    '$kuzov_auto',
    '$color_auto',
    '$nomer_prav',
    '$d',
    '$new_driver_id',
    1,
    0
    )
");

if ($add_user && $add_driver) {
    $res['status'] = "Успешно";
    $res['text'] = "Водитель добавлен";
    echo (json_encode($res));
    exit();
} else {
    echo (mysqli_error($link));
}

//var_dump($_POST);
/*
array(13) {
["fam"]=>
string(6) "zczcxc"
["name"]=>
string(5) "asdad"
["surname"]=>
string(6) "asdasd"
["phone"]=>
string(9) "123123123"
["name_auto"]=>
string(6) "asdasd"
["nomer_auto"]=>
string(7) "asdasds"
["kuzov_auto"]=>
string(10) "Седан"
["color_auto"]=>
string(8) "asdasdad"
["nomer_prav"]=>
string(7) "dasdasd"
["data_prav"]=>
string(6) "dasdad"
["email"]=>
string(10) "asdad@asda"
["password"]=>
string(4) "adad"
["password2"]=>
string(6) "asdasd"
}
*/