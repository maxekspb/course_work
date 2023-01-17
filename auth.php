<?php
require_once 'db_connect.php';
$login = trim($_POST['login']);
$password = trim($_POST['password']);

if(!empty($login) && !empty($password)){
    $query = $db->prepare('SELECT * FROM users WHERE login =:login');
    $query->execute(['login' => $login]);
    $result = $query->fetch(PDO::FETCH_OBJ);
    if(!$result){
        $err_msg="Неправильный логин";
        header("Location: index.php?error=$err_msg");
        exit;
    }
}
else{
    $err_msg="Имя пользователя и/или пароль не были введены";
    header("Location: index.php?error=$err_msg");
    exit;
}
$pass = hash('sha256', $password . $result->salt);
if($pass == $result->hash){
    echo 'its you';
    session_start();
    $_SESSION['login'] = true;
    $_SESSION['full_name'] = $result->full_name;
    if($result->teacher){
        $_SESSION['teacher'] = true;
    }
    else{
        $_SESSION['teacher'] = false;
    }
    if($result->admin){
        $_SESSION['admin'] = true;
    }
    else{
        $_SESSION['admin'] = false;
    }
    $_SESSION['class'] = $result->class ;

    header("Location: journal.php");
}
else{
    echo "i dont know you";
    $err_msg="Неправильный пароль";
    header("Location: index.php?error=$err_msg");
    exit;
}



