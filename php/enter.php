<?php

foreach($_POST as $item)
    if (empty($item))
        {
            echo 'Проверьте введенные данные';
            exit();
        }

$login = $_POST['email'];
$pass = $_POST['password'];

include 'connect.php';


$super_pass = md5($pass);

$q = mysqli_query($link,"SELECT id, email, password, level from user WHERE email='{$login}'")->fetch_all(MYSQLI_ASSOC)[0];
if ($q==NULL)
        {
            echo 'Пользователя не существует';
            exit();
        }
if ($super_pass == $q['password'])
{
    session_start();
    $_SESSION['id']=$q['id'];
    switch ($q['level'])
    {
        case "1":{
            echo "new_voditel.html";
        break;
        }
        case "2":{
            echo "voditel.html";
        break;
        }
        case "3":{
            echo "klient.html";
        break;
        }
        default: break;
    }
}

else
{
    echo "Пароль неверный";
    exit();
}