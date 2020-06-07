<?php

$id = (int) $_POST['key'];
session_start();
$a = (int) $_SESSION['id'];
include '../connect.php';

$q = mysqli_query($link, "UPDATE zakaz
                        SET status = 3,
                            id_voditel = 0
                        WHERE id = $id");

if ($q)
    echo "OK";
else
    echo mysqli_error($link);
