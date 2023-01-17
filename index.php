<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="w-350 p-5 shadow rounded">
    <form method="post" action="auth.php">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h3 class="display-4 fs-1 text-center">Авторизация</h3>
            <?php if(isset($_GET['error'])) { ?>
            <div class="alert alert-warning" role="alert">
            <?php
            echo htmlspecialchars($_GET['error']);
            ?>
            </div>
            <?php } ?>
        <div class="mb-3">
            <label for="login" class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" name="login">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-primary">Login</button>
        </div>
        </div>
    </form>
</div>

</body>
</html>