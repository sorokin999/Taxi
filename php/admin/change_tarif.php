<?php

$res = array([
    "status" => 'Отладка',
    'text' => 'test'
]);

include '../connect.php';
if (!empty($_POST['min_cost'])) {
    $min_cost = (int)$_POST['min_cost'];
    $c = mysqli_query($link,"UPDATE tarif
    SET price = $min_cost
    WHERE id = 1");
    $res['status']='Успешно';
}

if (!empty($_POST['km_cost'])){
    $km_cost = (int)$_POST['km_cost'];
    $c = mysqli_query($link,"UPDATE tarif
    SET km = $km_cost
    WHERE id = 1");
    $res['status']='Успешно';
}

if (!empty($_POST['comission'])){
    $comission = (int)$_POST['comission'];
    $c = mysqli_query($link,"UPDATE tarif
    SET comission = $comission
    WHERE id = 1");
    $res['status']='Успешно';
}

if ($res['status']=='Успешно')
    $res['text']='Тариф изменен';

echo (json_encode($res));
