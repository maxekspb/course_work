<?php
session_start();
if (!$_SESSION['admin']) {
    header("Location: index.php");
}

if((isset($_POST['login']) && isset($_POST['password']) && isset($_POST['full_name'])
    && !(empty($_POST['login']) && empty($_POST['password']) && empty($_POST['full_name'])))) {
    $login = $_POST['login'];
    $full_name = $_POST['full_name'];
    $full_name = mb_convert_case($full_name, MB_CASE_TITLE, "UTF-8");
    $password = $_POST['password'];
    $teacher = $_POST['teacher'];
    if($teacher == 'on'){
        $teacher = 1;
    }
    else{
        $teacher = 0;
    }
    $admin = $_POST['admin'];
    if($admin == 'on'){
        $admin = 1;
    }
    else{
        $admin = 0;
    }
    $tclass = $_POST['class'];
    $class = str_replace(" ", '', $tclass);
    $class = mb_strtoupper($class);
    $salt = random_bytes(16);

$hash = hash('sha256', $password . $salt);
require_once 'db_connect.php';

$query = $db->prepare("SELECT * FROM users WHERE login =:login LIMIT 1");

$query->execute(['login'=>$login]);
$count=$query->rowCount();
if ($count > 0) {
    $err_msg="Логин занят!";
    header("Location: add_user.php?error=$err_msg");
    exit;
}
else{
    $sql = $db->prepare("INSERT INTO `users` ( `login`, `full_name`, `class`, `teacher`, `admin`, `hash`, `salt`)
    VALUES ('$login', '$full_name', '$class', '$teacher', '$admin', '$hash', '$salt')");
    $sql->execute();
    $msg="Пользователь успешно добавлен";
    header("Location: add_user.php?success=$msg");
}
}
else{
    $err_msg="Вы не ввели логин, ФИО и/или пароль!";
    header("Location: add_user.php?error=$err_msg");
    exit;
}


