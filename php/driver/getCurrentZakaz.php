<?php

session_start();
$a = (int) $_SESSION['id'];

include '../connect.php';

$res="0";

$q = mysqli_query($link,"SELECT * FROM zakaz WHERE id_voditel = $a ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);

foreach($q as $item){
    $status = (int)$item['status'];
    if ($status==2)
    {
        $res = "<div class=\"row\">
        <div class=\"col-lg-12\">
            <div class=\"panel panel-default\">
                <div style=\"background:#444444; color:white;\" class=\"panel-heading\">Текущий заказ</div>
                <div class=\"panel-body\">
                    <div class=\"col-md-6\">
                    <span>Откуда: <b>" . $item["location_1"] . "</b></span><br>
                    <span>Куда: <b>" . $item['location_2'] . "</b></span><br>
                    <span>Расстояние: <b>" . $item['distance'] . "</b></span><br>
                    <span>Стоимость: <b>" . $item['price'] . " руб. </b> <b style=\"color:maroon;\">(Налог: " . $item['dohod'] . " руб.)</b></span><br>
                    <span>Номер клиента: <b>".$item['user_phone']." </b></span><br><br>
                        <div style=\"display:flex; justify-content:space-betveen;\">
                        <button style=\"margin-right:10px; background:#30a5ff; border:0;\" class=\"btn btn-md btn-success\" onclick = completeZakaz(" . $item["id"] . ",".$item["dohod"].")>Завершить заказ</button>
                        <button class=\"btn btn-md btn-danger\" onclick = cancelZakaz(" . $item["id"] . ")>Отменить заказ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    break;
    }
    if ($status==0)
    {
        $res="OK";
    break;
    }
    if ($status ==3)
    {
        $res = "OK";
    break;
    }
}
echo $res;