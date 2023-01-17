<?php
session_start();
if(!$_SESSION['login']){
    header("Location: index.php");
}
$class = $_SESSION['class'];
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Журнал</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
    <a class="btn btn-danger rounded p-1 " style="float: right" href="exit.php" role="button">Выйти</a>
    <a class="btn btn-outline-dark rounded p-1 " style="float: right" href="create_user.php" role="button">Админ панель</a>

</head>
<h1 class="d-flex justify-content-center " style="padding: 20px">Журнал успеваемости</h1>
<?php
if(!($_SESSION['teacher'] || $_SESSION['admin'])){

    echo '<h2 class="d-flex justify-content-center " style="padding: 5px">Ваш класс ';
    echo $class;
    echo '</h2>';
}
?>
<body >
<div class="row-cols-1 col-md-8 mx-auto w-25 p-5 shadow rounded justify-content-center align-content-center">
    <form method="post">
        <select name="userselect" id="userselect"  class=" form-select form-select-sm mb-3 ">
            <option value="0">Выберите предмет</option>
            <?php
            require_once "db_connect.php";
            $query = $db->prepare("SELECT DISTINCT predmet FROM grades");
            $query->execute();
            while ($result = $query->fetch()){
                ?>
                <option value="<?php
                echo $result['predmet'];
                ?>"><?php
                    echo $result['predmet'];
                    //$predmet = $result['predmet'];

                    ?>
                </option>
                <?php
            }
            ?>
        </select>
        <?php
        if($_SESSION['teacher'] == 1 || $_SESSION['admin'] == 1){
            ?>
            <select name="class" class="form-select form-select-sm mb-3 ">
                <option value="0">Выберите класс</option>
                <?php
                $query = $db->prepare("SELECT DISTINCT class FROM users");
                $query->execute();
                while ($result = $query->fetch()){
                    ?>
                    <option value="<?php
                    echo $result['class'];
                    ?>"><?php
                        echo $result['class'];
                        $_SESSION['class'] = $result['class'];
                        ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <?php
        }

        ?>
        <button class="btn-outline-dark rounded" type="submit" name="submit">Выбрать</button>
    </form>
</div>

<?php

if($_SESSION['teacher'] == 1 || $_SESSION['admin'] == 1){
    $class = $_POST['class'];
}
?>


    <?php
    if((isset($_POST['userselect'])  && ($_POST['userselect']) != 0)){
        $_SESSION['predmet'] = $_POST['userselect'];
    }
$query2 = $db->prepare("SELECT * FROM users WHERE class =:class ORDER BY full_name");
$query2->execute(['class' => $class]);
$num = 1;
if((!empty($class) && $_POST['userselect'] != 0)){
    $flag = 1;
?>
<div class=" w-100 p-5">
    <h2 class="d-flex justify-content-center" style="padding: 10px">Успеваемость по: <?php
        if((isset($_POST['userselect'])  && ($_POST['userselect']) != 0)) {
            echo $_POST['userselect'];
            $sel_predmet = $_POST['userselect'];
        }

        else{ ?><h2 class="d-flex justify-content-center " style="padding: 10px"><?php
            echo "предмет не выбран";
            ?> </h2><?php
        }?></h2>
<table class="table table-hover table-bordered caption-top table-responsive-md" style=" border: 1px solid black; display: inline-block; vertical-align: top;
	max-width: 100%;
	overflow-x: auto;
	white-space: nowrap;
	-webkit-overflow-scrolling: touch">
    <thead >
    <tr  class="table-dark">
        <th scope="col">Номер</th>
        <th scope="col">ФИО</th>
        <?php
        $count = 0;
        $arr = [];
        $query1 = $db->prepare("SELECT DISTINCT date, predmet FROM grades WHERE class =:class ORDER BY date");
        $query1->execute(['class' => $class]);

        while ($result1 = $query1->fetch()){
            if(($result1['predmet'] == $sel_predmet) && isset($result1['date'])){
                ?>
        <th scope="col"> <?php
            echo date('d.m.y', strtotime($result1['date']));
            $arr[] = $result1['date'];
            $count++;
            ?></th>
        <?php
            }
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <tr><?php
        while ($result2 = $query2->fetch()){
        ?>
        <th scope="row"> <?php
            echo $num++;
            ?> </th>
            <td> <?php
                echo $result2['full_name'];
                ?> </td>
        <?php
        $query3 = $db->prepare("SELECT * FROM grades WHERE user_id =:user_id");
        $query3->execute(['user_id' => $result2['id']]);
        $i = 0;
        while ($result3 = $query3->fetchALL()){
            ?>
            <?php
            for($j = 0;$j < $count; $j++){
                ?>
                <td>
                    <?php

                foreach ($result3 as $row) {
                ?>

                    <?php
                    if($row['date'] == $arr[$j] && $row['predmet'] == $sel_predmet){
                    echo $row['grade'];
                }
                }
                ?>
                </td>
                <?php
            }
            }
        ?>
        </tr>
        <?php
        }
        ?>
    <tr><td></td></tr>
    </tbody>
</table>

<?php
}
else {?><h2 class="d-flex justify-content-center " style="padding: 10px"><?php
            echo "Предмет не выбран";
            $flag = 0;
            ?> <?php
        } ?> </h2>
    <?php
    if(($_SESSION['teacher'] == 1 || $_SESSION['admin'] == 1) && $flag==1){ ?>
    <form method="post" action="set_grade.php">
          <span class="input-group-text w-100 ">Выставить оценку &nbsp;&nbsp;
              <div class="input-group">
            <select name="user_to_grade"   class="  form-select   " style="margin-right: 7px">
                <option value="0">Выберите ученика</option>
                <?php
                $query5 = $db->prepare("SELECT * FROM users WHERE class=:class");
                $query5->execute(['class' => $class]);
                while ($result5 = $query5->fetch()){

                    ?>
                    <option value="<?php
                    echo $result5['id'];
                    ?>"><?php
                        echo $result5['full_name'];
                        ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <select name="grade"   class="  form-select   " style="margin-right: 10px">
                <option value="0">Выберите оценку</option>
                <option value="5">Отлично - 5</option>
                <option value="4">Хорошо - 4</option>
                <option value="3">Удовлетворительно - 3</option>
                <option value="2">Неудовлетворительно - 2</option>
            </select>
                  <select name="grade_predmet"   class="  form-select   " style="margin-right: 10px">
                <option selected value="<?php echo $sel_predmet?>"><?php echo $sel_predmet?></option>
            </select>
                  <select name="class"   class="  form-select   " style="margin-right: 10px">
                <option selected value="<?php echo $class?>"><?php echo $class?></option>
            </select>
                    <input type="date" name="date" class="  form-control   " style="margin-right: 10px">
                  <button name="set_grade" class="btn-outline-dark rounded" type="submit">Поставить оценку</button>
              </span>


    <?php
    }
    ?>
</div></form>
</div>

        <form method="post" action="create_hw.php">
<div class="row-cols-1 col-md-8 mx-auto w-75 p-5 shadow rounded justify-content-center align-content-center">
    <?php if(isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php
            echo htmlspecialchars($_GET['success']);
            ?>
        </div>
    <?php } ?>
    <?php if(isset($_GET['error'])) { ?>
        <div class="alert alert-warning" role="alert">
            <?php
            echo htmlspecialchars($_GET['error']);
            ?>
        </div>
    <?php } ?>
    <?php
    if($_SESSION['teacher'] || $_SESSION['admin']){
    ?>
<div class="mb-3">
    <select name="class_hw"   class="form-select" style="margin: 7px">
        <option value="0">Выберите класс</option>
        <?php
        $query = $db->prepare("SELECT DISTINCT class FROM users");
        $query->execute();
        while ($result = $query->fetch()){
            ?>
            <option value="<?php
            echo $result['class'];
            ?>"><?php
                echo $result['class'];
                ?>
            </option>
            <?php
        }
        ?>
    </select>
    <select name="predmet_hw"   class="  form-select   " style="margin: 7px">
        <option value="0">Выберите предмет</option>
        <?php
        $query = $db->prepare("SELECT DISTINCT predmet FROM grades");
        $query->execute();
        while ($result = $query->fetch()){
            ?>
            <option value="<?php
            echo $result['predmet'];
            ?>"><?php
                echo $result['predmet'];
                ?>
            </option>
            <?php
        }
        ?>
</div>
<div class="mb-3">
    <label  class="form-label">Текст домашнего задания</label>
    <textarea name="text_hw" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
    <button name="hw" class="btn-outline-dark rounded" type="submit">Отправить ДЗ</button>
</div>

        </form>
<?php
}

?>
<div class="row-cols-1 col-md-8 mx-auto w-75 p-5 shadow rounded justify-content-center align-content-center">
<?php
require_once 'db_connect.php';
$query = $db->prepare("SELECT * FROM homework ORDER BY id");
$query->execute();
while ($result = $query->fetch()){
    ?>
    <div class="p-3 shadow rounded" style="background-color: darkgray"><?php
    echo $result['text'];
        ?></div><div style="text-align: right"> Автор:  <?php
        echo $result['full_name'];
        ?></div>
    <?php
}
?>
</div>
</body>
</html>
