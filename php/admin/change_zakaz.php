<?php

$a = (int)$_POST['key'];

include '../connect.php';

$q = mysqli_query($link,"UPDATE zakaz
SET status = 3,
id_voditel = 0
WHERE id = $a
");

if ($q)
    echo("OK");
else
    echo(mysqli_error($link));