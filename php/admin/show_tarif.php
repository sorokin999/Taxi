<?php

include '../connect.php';

$q = mysqli_query($link,"SELECT * FROM tarif")->fetch_all(MYSQLI_ASSOC)[0];
$res = "
<span>Минимальная стоимость поездки: <b>".$q['price']." руб.</b></span><br>
<span>Стоимость за километр: <b>".$q['km']." руб.</b></span><br>
<span>Комиссия: <b>".$q['comission']." %</b></span>
";

echo $res;