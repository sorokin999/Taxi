<?php

$a = $_POST['key'];

include '../connect.php';

$lev = (int)mysqli_query($link,"SELECT status FROM voditel WHERE id_user = $a")->fetch_all(MYSQLI_ASSOC)[0]['status'];
$anti_lev;
if ($lev == 1)
    $anti_lev=0;
else
    $anti_lev=1;

$q = mysqli_query($link,"UPDATE voditel
SET status = $anti_lev
WHERE id_user = $a
");

if ($q)
    echo("Успешно");
else
    echo(mysqli_error($link));