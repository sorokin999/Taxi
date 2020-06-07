<?php
include 'connect.php';

$name = $_POST['name'];
$surname = $_POST['surname'];
$otch = $_POST['otch'];
$phone = $_POST['phone'];
$email = $_POST['contactsForm'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$lev = 3;


foreach ($_POST as $item)
if (empty($item))
    {
        echo 'Проверьте введенные данные';
        exit();
    }
else {
    if ($password != $password2)
    {
        echo 'Пароли не совпадают';
        exit();
    }

    $p = (int)mysqli_query($link,"SELECT COUNT(*) as 'kol' from user WHERE email='$email'")->fetch_all(MYSQLI_ASSOC)[0]['kol'];
    if ($p>0)
    {
        echo 'Email занят. Выберите другой';
        exit();
    }

    $nom = mysqli_query($link,"SELECT COUNT(*) as 'kol' FROM user WHERE phone = '{$phone}'")->fetch_all(MYSQLI_ASSOC)[0]['kol'];
    if ($nom>0)
    {
        echo 'Номер телефона занят. Введите другой';
        exit();
    }
    $super_pass = md5($password);

    $query="INSERT INTO user(name,surname,otch,phone,email,password, level) VALUES ('$name','$surname','$otch','$phone','$email','$super_pass', '$lev')";
    $add = mysqli_query($link,$query); 
     if ($add)
        {
            echo 'OK';
            exit();
        }
    else
        {
            echo 'ERROR';
            exit();
        }
}
