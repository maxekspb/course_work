<?php
session_start();
if (!$_SESSION['admin'] && !$_SESSION['teacher']) {
    header("Location: journal.php");
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Admin panel</title>
    <link rel="icon" href="favicon.ico">

</head>
<body class="d-flex justify-content-center align-content-center ">
<div class="w-350 p-5 shadow rounded">
    <form method="post" action="create_user.php">
        <div class="d-flex  flex-column">
            <h3 class="display-4 fs-1 text-center">Добавление пользователей</h3>
            <?php if(isset($_GET['error'])) { ?>
            <div class="alert alert-warning" role="alert">
                <?php
                echo htmlspecialchars($_GET['error']);
                ?>
                <?php } ?>
            </div>
            <?php if(isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo htmlspecialchars($_GET['success']);
                ?>
                <?php ?>
            </div>
            <?php
            } ?>

            <div class="mb-3">
                <label for="full_name" class="form-label">ФИО</label>
                <input type="text" class="form-control" placeholder="ФИО" name="full_name">
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Класс</label>
                <input type="text" class="form-control" name="class" placeholder="Класс">
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" placeholder="Логин" name="login">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" placeholder="Пароль" name="password">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="teacher"">
                <label class="form-check-label" for="teacher">
                    Учитель
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="admin"">
                <label class="form-check-label" for="admin">
                    Админ
                </label>
            </div>
            <div class="d-flex justify-content-center ">
                <button type="submit" class="btn btn-primary">Создать пользователя</button>
                <a class="btn btn-danger rounded p-1 " style="margin-left: 60px" href="exit.php" role="button">Выйти</a>
            </div>

        </div>
    </form>

</div>

</body>

</html>
