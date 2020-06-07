<?php

$id = (int) $_POST['key'];
$price = (int) $_POST['price'];
session_start();
$a = (int) $_SESSION['id'];
include '../connect.php';

$q = mysqli_query($link, "UPDATE zakaz
                        SET status = 1
                        WHERE id = $id");

$idvod = mysqli_query($link,"SELECT id, nalog FROM voditel WHERE id_user = $a")->fetch_all(MYSQLI_ASSOC)[0];

$iid = (int)$idvod['id'];
$nalvod = (int)$idvod['nalog'];
$nalvod += $price;

$qq = mysqli_query($link, "UPDATE voditel
                            SET nalog = $nalvod
                            WHERE id = $iid");
if ($q && $qq)
    echo "OK";
else
    echo mysqli_error($link);
