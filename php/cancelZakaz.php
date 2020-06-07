<?php

$id = (int) $_POST['key'];

include 'connect.php';

$q = mysqli_query($link, "UPDATE zakaz
                        SET status = 0
                        WHERE id = $id");

if ($q)
    echo "OK";
else
    echo mysqli_error($link);
