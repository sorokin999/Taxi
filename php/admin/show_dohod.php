<?php

include '../connect.php';

$res = "<thead><tr>
        <th scope=\"col\">№</th>
        <th scope=\"col\">Текущий баланс</th>
        <th scope=\"col\">Доход</th>
        <th scope=\"col\">Расход</th>
        <th scope=\"col\">Время транзакции</th>
        </tr></thead><tbody>";
$k = 1;
$q = mysqli_query($link, "SELECT * FROM bank ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
foreach ($q as $item) {
    $res .= "<tr>
    <th scope=\"row\">".$k."</td>
    <td><b>".$item['sum_bank']."</b></td>
    <td><b style=\"color:green;\">+".$item['sum_gain']."</b></td>
    <td><b style=\"color:red;\">-".$item['sum_lose']."</b></td>
    <td>".$item['time_operation']."</td>
    <tr>";
    $k++;
}

$res .="</tbody>";
echo $res;