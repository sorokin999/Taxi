<?php

//текушщий баланс
//1. сколько сейчас денег общая прибыль
//2. общий налог
//3. общие расходы

$res = "";
include '../connect.php';

$q = (int) mysqli_query($link, "SELECT sum_bank FROM bank ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC)[0]['sum_bank'];
$qq = mysqli_query($link, "SELECT SUM(nalog) as 'sum' FROM voditel")->fetch_all(MYSQLI_ASSOC)[0];
$qqq = mysqli_query($link, "SELECT SUM(sum_gain) as 'sum' FROM bank")->fetch_all(MYSQLI_ASSOC)[0];
$qqqq = mysqli_query($link, "SELECT SUM(sum_lose) as 'sum' FROM bank")->fetch_all(MYSQLI_ASSOC)[0];
$raz = (int) $qqq['sum'] - (int) $qqqq['sum'];
$sost = "";
if ($raz > 0)
    $sost .= "<b style=\"color:green;\">+" . $raz . " руб.</b>";
elseif ($raz < 0)
    $sost .= "<b style=\"color:red;\">" . $raz . " руб.</b>";
else
    $sost = "0 руб.";

$res .= "<span>Текущий баланс : <b>" . $q . " руб.</b></span><br>
        <span>Общий налог : <b>" . $qq['sum'] . " руб.</b></span><br>
        <span>Общий доход : <b>" . $qqq['sum'] . " руб.</b></span><br>
        <span>Расходы за все время : <b>" . $qqqq['sum'] . " руб.</b></span><br>
        <span>Состояние : " . $sost . "</span>";

echo ($res);
