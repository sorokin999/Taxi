<?php

$a = $_POST['rass'];

$a = substr($a,strpos($a,' '),10);
$a = (int)substr($a,1,strpos($a,' к')-1);

include 'connect.php';
$q = mysqli_query($link,"SELECT price,km FROM tarif")->fetch_all(MYSQLI_ASSOC)[0];
$price = $q['price']+$a*$q['km'];

echo($price);