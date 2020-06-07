<?php
session_start();
if (!empty($_SESSION))
{
    include '../connect.php';
    $b = 0;

    $i = (int)$_SESSION['id'];
    $q = (int)mysqli_query($link,"SELECT level FROM user WHERE id = $i")->fetch_all(MYSQLI_ASSOC)[0]['level'];
    if ($q == 1)
    {
        $b=1;
    }
    echo ($b);
    exit();
}
else
{
    $b = 0;
    echo $b;
    exit();
}