<?php

include '../connect.php';

$res = "<thead>
    <tr>
        <th scope=\"col\">№</th>
        <th scope=\"col\">ФИО</th>
        <th scope=\"col\">Номер телефона</th>
        <th scope=\"col\">Серия и номер прав</th>
        <th scope=\"col\">Дата получения прав</th>
        <th scope=\"col\">Налог</th>
        <th scope=\"col\">Статус</th>
        <th scope=\"col\">Действия</th>
    </tr>
</thead><tbody>";
$k=1;
$q = mysqli_query($link,"SELECT * FROM user WHERE level=2")->fetch_all(MYSQLI_ASSOC);
    foreach($q as $item)
    {
        $qq = mysqli_query($link, "SELECT nomer_prav, data_prav, status, nalog FROM voditel WHERE id_user = '{$item['id']}'")->fetch_all(MYSQLI_ASSOC)[0];
        $res .= "<tr>
            <th scope=\"row\">
                ".$k."
            </td>
            <td>
                ".$item['surname']." ".$item['name']." ".$item['otch']."
            </td>
            <td>
                ".$item['phone']."
            </td>
            <td>
                ".$qq['nomer_prav']."
            </td>
            <td>
                ".$qq['data_prav']."
            </td>
            <td>
                ".$qq['nalog']." руб.
            </td>
            <td>";
                if ($qq['status'] == 1)
                    $res.="В работе";
                else
                    $res.="Отстранен от работы";
            
            $res .= "</td>
            <td>
                <a href=\"#\" onClick=deleteDriver(".$item['id'].")>Удалить водителя</a><br>
                <a href=\"#\" onClick=changeDriverStatus(".$item['id'].")>Изменить статус</a><br>
                <a href=\"#\" onClick=payDriver(".$item['id'].")>Оплатил налог</a>
            </td>
        </tr>";
        $k++;
    }


$res .="</tbody>";

echo ($res);