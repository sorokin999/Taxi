<?php

$a = (int) $_POST['key'];

include '../connect.php';
$q = mysqli_query($link, "DELETE FROM zakaz WHERE id = $a");
if ($q)
    echo "OK";
else
    echo mysqli_error($link);
