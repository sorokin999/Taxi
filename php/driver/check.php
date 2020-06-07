<?php
session_start();
$b = "0";
if (!empty($_SESSION)) {
    include '../connect.php';

    $i = (int) $_SESSION['id'];
    $q = mysqli_query($link, "SELECT level FROM user WHERE id = $i")->fetch_all(MYSQLI_ASSOC)[0]['level'];
    if ($q == 2) {
        $status = (int) mysqli_query($link, "SELECT status FROM voditel WHERE id_user = $i")->fetch_all(MYSQLI_ASSOC)[0]['status'];
        if ($status == 0) {
            $b = "Заблокирован";
            echo $b;
            exit();
        } else {
            $b = "1";
            echo ($b);
            exit();
        }
    } else {
        echo "У вас нет доступа к странице водителя";
        exit();
    }
} else {
    echo $b;
    exit();
}
