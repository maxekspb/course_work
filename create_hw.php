<?php
session_start();
if (!$_SESSION['admin'] && !$_SESSION['teacher']) {
    header("Location: journal.php");
}
require_once 'db_connect.php';
if(isset($_POST['class_hw']) && isset($_POST['predmet_hw']) && isset($_POST['text_hw'])){
$class = $_POST['class_hw'];
$predmet = $_POST['predmet_hw'];
$text = $_POST['text_hw'];
$full_name = $_SESSION['full_name'];

$sql = $db->prepare("INSERT INTO `homework` (`class`,`predmet`, `text`, `full_name`)
                                        VALUES ('$class', '$predmet', '$text', '$full_name')");
$sql->execute();
$msg = "Домашнее задание успешно отправлено";
header("Location: journal.php?success=$msg");
}
else{
    $error="Неизвестная ошибка";
    header("Location: journal.php?error=$error");
}
