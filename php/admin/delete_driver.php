<?php

include '../connect.php';

$num = (int)$_POST['key'];
$num_driver = (int)mysqli_query($link,"SELECT id FROM voditel WHERE id_user = '{$num}'")->fetch_all(MYSQLI_ASSOC)[0]['id'];
$del_driver = mysqli_query($link,"DELETE FROM voditel WHERE id = {$num_driver}");
$del_user = mysqli_query($link,"DELETE FROM user WHERE id = {$num}");
if ($del_driver&&$del_user)
{
    echo 'Успешно';
    exit();
}
else
{
    echo (mysqli_error($link));
    exit();
}