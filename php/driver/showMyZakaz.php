<?php

session_start();
$a = (int) $_SESSION['id'];

include '../connect.php';
$res = "";

$q = mysqli_query($link, "SELECT * FROM zakaz WHERE (id_voditel = $a) AND ((status = 1) OR (status = 0)) ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
foreach ($q as $item) {
    $status = "";
    if ($item['status'] == "1")
        $status = "<b style=\"color:green\">Выполнен</b>";
    if ($item['status'] == "0")
        $status = "<b style=\"color:red\">Отменен</b>";
    $res .= "<div class=\"row\">
    <div class=\"col-lg-12\">
        <div class=\"panel panel-default\">
            <div style=\"background:#444444; color:white;\" class=\"panel-heading\">Заказ №" . $item["id"] . "</div>
            <div class=\"panel-body\">
                <div class=\"col-md-6\">
                <span>Время: <b>" . $item['data'] . "</b></span><br>
                <span>Откуда: <b>" . $item["location_1"] . "</b></span><br>
                <span>Куда: <b>" . $item['location_2'] . "</b></span><br>
                <span>Расстояние: <b>" . $item['distance'] . "</b></span><br>
                <span>Стоимость: <b>" . $item['price'] . " руб. </b> <b style=\"color:maroon;\">(Налог: " . $item['dohod'] . " руб.)</b></span><br><br>
                    Статус : ".$status."<br>
                </div>
            </div>
        </div>
    </div>
</div>";
}

echo $res;
