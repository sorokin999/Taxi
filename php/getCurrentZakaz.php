<?php

session_start();
$a = (int) $_SESSION['id'];

include 'connect.php';

$res = "0";

$item = mysqli_query($link, "SELECT * FROM zakaz WHERE id_user = $a ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC)[0];

    $status = (int) $item['status'];
    if ($status == 3) {
        $status = "Поиск водителя";
    } elseif ($status == 2) {
        $q = (int) $item['id_voditel'];
        $qq = mysqli_query($link, "SELECT name_auto, nomer_auto, color_auto FROM voditel WHERE id_user = '{$item["id_voditel"]}'")->fetch_all(MYSQLI_ASSOC)[0];
        $nomer = mysqli_query($link,"SELECT phone FROM user WHERE id = '{$item["id_voditel"]}'")->fetch_all(MYSQLI_ASSOC)[0]['phone'];
        $status = "<br>На ваш заказ назначено: <br> Цвет:" . $qq['color_auto'] . "<br>" . $qq['name_auto'] . "<br>Номер автомобиля: " . $qq['nomer_auto']."<br>
        Телефон водителя: <b>".$nomer."</b>";
    } elseif ($status==1) {
        echo "OK";
        exit();
    }
    elseif ($status==null){
        echo "NO";
        exit();
    }
    $res = "
    <div class=\"row\">
        <div class=\"col-lg-12\">
            <div class=\"panel panel-default\">
                <div style=\"background:#444444; color:white;\" class=\"panel-heading\">Ваш заказ</div>
                <div class=\"panel-body\">
                    <div class=\"col-md-6\">
                    <span>Место отправки: <b>" . $item["location_1"] . "</b></span><br>
                    <span>Место назначения: <b>" . $item['location_2'] . "</b></span><br>
                    <span>Расстояние: <b>" . $item['distance'] . "</b></span><br>
                    <span>Стоимость: <b>" . $item['price'] . " руб. </b></span><br>
                    <span>Статус заказа: <b>" . $status . " </b></span><br><br>
                    
                        <div style=\"display:flex; justify-content:space-betveen;\">
                        <button class=\"btn btn-md btn-danger\" onclick = cancelZakaz(" . $item["id"] . ")>Отменить заказ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";
echo $res;
