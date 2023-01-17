<?php
try {
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $db = new PDO('mysql:host=localhost;dbname=course_work', 'root', 'root', $options);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die("Ошибка подключения базы данных");
}