<?php

$text = $_POST['text'];
$idZakaz = (int) $_POST['zakaz'];

include 'connect.php';

$status = (int) mysqli_query($link, "SELECT status FROM zakaz WHERE id = $idZakaz")->fetch_all(MYSQLI_ASSOC)[0]['status'];
if ($status == 0)
    echo ("Заказ был отменен. Отзыв оставить нельзя.");
else {
    $feedback = mysqli_query($link, "UPDATE zakaz
SET otziv = '$text'
WHERE id = $idZakaz");
    if ($feedback)
        echo 'Успешно';
}

/**array(2) {
["text"]=>
string(7) "sdadsda"
["zakaz"]=>
string(2) "56"
} */
