<?php

session_start();
$a = (int) $_SESSION['id'];

include '../connect.php';

$res = "";

$q = (int) mysqli_query($link, "SELECT nalog FROM voditel WHERE id_user = $a")->fetch_all(MYSQLI_ASSOC)[0]['nalog'];

$col = (int) mysqli_query($link, "SELECT COUNT(*) as 'kol' FROM zakaz WHERE status=1 AND id_voditel = $a")->fetch_all(MYSQLI_ASSOC)[0]['kol'];

$sum = 0;

$qq = mysqli_query($link, "SELECT price,dohod FROM zakaz WHERE status=1 AND id_voditel = $a")->fetch_all(MYSQLI_ASSOC);
foreach ($qq as $item) {
    $b = (int) $item['price'] - (int) $item['dohod'];
    $sum += $b;
}

$res .= "<span>Количество выполненных заказов: <b>" . $col . "</b></span><br>
         <span>Всего заработано: <b>" . $sum . " руб.</b></span><br>
         <span>Неуплаченный налог: <b>" . $q . " руб.</b></span><br><br>
         <button class=\"btn btn-md btn-success\" onclick=payNalog()>Оплатить налог</button>";

echo $res;

//кол-во выполненых заказов цифра +
//сколько заработано
//налог