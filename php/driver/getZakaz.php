<?php

include '../connect.php';

$res = "";

$q = mysqli_query($link,"SELECT * FROM zakaz WHERE status = 3 ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
foreach($q as $item){
    $res .= "<div class=\"row\">
    <div class=\"col-lg-12\">
        <div class=\"panel panel-default\">
            <div style=\"background:#444444; color:white;\" class=\"panel-heading\">Заказ №".$item["id"]."</div>
            <div class=\"panel-body\">
                <div class=\"col-md-6\">
                <span>Откуда: <b>".$item["location_1"]."</b></span><br>
                <span>Куда: <b>".$item['location_2']."</b></span><br>
                <span>Расстояние: <b>".$item['distance']."</b></span><br>
                <span>Стоимость: <b>".$item['price']." руб. </b> <b style=\"color:maroon;\">(Налог: ".$item['dohod']." руб.)</b></span><br><br>
                    <button style=\"background:#30a5ff; border:0;\" class=\"btn btn-md btn-danger\" onclick = setZakaz(".$item["id"].")>Принять заказ</button>
                </div>

            </div>
        </div>
    </div>
</div>";
}
echo $res;