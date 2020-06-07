<?php

session_start();
include '../connect.php';
$id = (int)$_SESSION['id'];

$q = mysqli_query($link,"SELECT name FROM user WHERE id = $id")->fetch_all(MYSQLI_ASSOC)[0]['name'];

echo $q;