<?php

include '../connect.php';

$res = "<thead>
    <tr>
        <th scope=\"col\">№</th>
        <th scope=\"col\">Место отправления</th>
        <th scope=\"col\">Место назначения</th>
        <th scope=\"col\">Стоимость</th>
        <th scope=\"col\">Клиент</th>
        <th scope=\"col\">Водитель</th>
        <th scope=\"col\">Дата и время назначения заказа</th>
        <th scope=\"col\">Статус</th>
        <th scope=\"col\">Отзыв о заказе</th>
        <th scope=\"col\">Действия</th>
    </tr>
</thead><tbody>";
$k = 1;
$q = mysqli_query($link, "SELECT * FROM zakaz ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
foreach ($q as $item) {
    $qq = (int) $item['id_voditel'];
    $qqq = mysqli_query($link, "SELECT name,surname,otch,phone FROM user WHERE id = $qq")->fetch_all(MYSQLI_ASSOC)[0];
    $driver = $qqq['surname'] . " " . $qqq['name'] . " " . $qqq['otch'] . " " . "<br><b>" . $qqq['phone'] . "</b>";
    $client;
    if (empty($item['id_user'])) {
        $client = $item['user_phone'];
    } else {
        $c = mysqli_query($link, "SELECT name,surname,otch FROM user WHERE id = '{$item['id_user']}'")->fetch_all(MYSQLI_ASSOC)[0];
        $client = $c['surname'] . " " . $c['name'] . " " . $c['otch'];
    }
    $zakaz;
    switch ($item['status']) {
        case 0: {
                $zakaz = "Не выполнен";
                break;
            }
        case 1: {
                $zakaz = "Выполнен";
                break;
            }
        case 2: {
                $zakaz = "Выполняется";
                break;
            }
        case 3: {
                $zakaz = "В ожидании";
                break;
            }
    }
    $res .= "<tr>
            <th scope=\"row\">
                " . $k . "
            </td>
            <td>
                " . $item['location_1'] . "
            </td>
            <td>
                " . $item['location_2'] . "
            </td>
            <td>
                " . $item['price'] . "
            </td>
            <td>
                " . $client . "
            </td>
            <td>
                " . $driver . "
            </td>
            <td>
                " . $item['data'] . "
            </td>
            <td>
                " . $zakaz . "
            </td>
            <td>
                " . $item['otziv'] . "
            </td>
            <td>
                <a href=\"#\" onClick=changeZakaz(" . $item['id'] . ")>Изменить статус</a>
                <a href=\"#\" onClick=deleteZakaz(" . $item['id'] . ")>Удалить</a>
            </td>
        </tr>";
    $k++;
}


$res .= "</tbody>";

echo ($res);
