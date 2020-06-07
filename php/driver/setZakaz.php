<?php

include '../connect.php';

$a = $_POST['key'];
session_start();
$id = $_SESSION['id'];

$res = "";

$q = mysqli_query($link, "SELECT * FROM zakaz WHERE id = $a")->fetch_all(MYSQLI_ASSOC)[0];
    $qq = mysqli_query($link,"UPDATE zakaz
                            SET status = 2,
                            id_voditel = $id
                            WHERE id=$a");

$res .= "<div class=\"row\">
    <div class=\"col-lg-12\">
        <div class=\"panel panel-default\">
            <div style=\"background:#444444; color:white;\" class=\"panel-heading\">Текущий заказ</div>
            <div class=\"panel-body\">
                <div class=\"col-md-6\">
                <span>Откуда: <b>" . $q["location_1"] . "</b></span><br>
                <span>Куда: <b>" . $q['location_2'] . "</b></span><br>
                <span>Расстояние: <b>" . $q['distance'] . "</b></span><br>
                <span>Стоимость: <b>" . $q['price'] . " руб. </b> <b style=\"color:maroon;\">(Налог: " . $q['dohod'] . " руб.)</b></span><br>
                <span>Номер клиента: <b>".$q['user_phone']." </b></span><br><br>
                    <button style=\"background:#30a5ff; border:0;\" class=\"btn btn-md btn-success\" onclick = completeZakaz(" . $q["id"] . ")>Заказ выполнен</button>
                </div>
            </div>
        </div>
    </div>
</div>";
echo $res;
