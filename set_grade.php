<?php
session_start();

if (!$_SESSION['admin'] || !$_SESSION['teacher']) {
    header("Location: journal.php");
}
$_SESSION['return'];
require_once 'db_connect.php';
if((isset($_POST['user_to_grade']) && isset($_POST['grade']) && isset($_POST['date'])
    && !(empty($_POST['user_to_grade']) && empty($_POST['grade']) && empty($_POST['date'])))){
    $predmet = $_POST['grade_predmet'];
    $id = $_POST['user_to_grade'];
    $grade = $_POST['grade'];
    $class = $_POST['class'];
    $date = $_POST['date'];
    $_SESSION['class']=$class;
    $_SESSION['predmet']=$predmet;
    $sql = $db->prepare("INSERT INTO `grades` (`user_id`, `class`, `grade`, `date`, `predmet` ) VALUES ('$id', '$class','$grade', '$date', '$predmet')");
    $sql->execute();
    $msg="Оценка успешно поставлена";
    header("Location: journal.php?success=$msg");
}
else{
    $error="Неизвестная ошибка";
    header("Location: journal.php?error=$error");
}
