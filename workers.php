<?php session_start(); ?>
<?php $cur_page = "workers"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Работники</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) { ?>
            <div class="container">
                <? include("modules/menu.php"); ?>
                <div class="content">
                    <div id="popup" class="center hidden">
                        <div id="popup_closer"><p>X</p></div>
                        <form class="authform" action="../actions/create_worker.php" method="post">
                            <input required type="text" name="name" placeholder="ФИО">
                            <select name="role">
                                <option selected value="worker">Работник</option>
                                <option value="engineer">Инженер</option>
                                <option value="accountant">Бугалтер</option>
                                <option value="humanres">Кадровик</option>
                                <option value="admin">Администратор</option>
                            </select>
                            <input type="text" name="speciality" placeholder="Специальность">
                            <input type="text" name="salary" placeholder="Зарплата">
                            <input required id="username" type="text" name="login" placeholder="Логин">
                            <input required type="text" name="password" placeholder="Пароль">
                            <button id="createbtn" class="basebtn">Добавить</button>
                        </form>
                    </div>
                        <div class="flex">
                            <h1>Работники</h1>
                            <?php if($_SESSION['role'] === 'admin') { ?> <div class="plusbtn margleft" id="popup_activator"></div> <?php } ?>
                        </div>
                    <?php if($_GET['deleted'] === 'true') { ?>
                        <div class="succes_message">
                            <p>Удаление прошло успешно</p>
                        </div>
                    <?php } ?>
                    <?php if($_GET['created'] === 'true') { ?>
                        <div class="succes_message">
                            <p>Добавление прошло успешно</p>
                        </div>
                    <?php } ?>
                    <h2>Управляющий персонал</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Должность</th>
                                <th>Зарплата</th>
                                <?php if($_SESSION['role'] === 'admin') { ?> <th></th> <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM users WHERE role <> 'worker'";
                                $workers = mysqli_query($db, $query);
                                foreach($workers as $worker) {
                                    echo "<tr>";
                                    echo "<td>" . $worker['name'] . "</td>";
                                    echo "<td>" . $worker['speciality'] . "</td>";
                                    echo "<td>" . $worker['salary'] . "</td>";
                                    if($_SESSION['role'] === 'admin') { echo "<td><a href='actions/del_worker.php?id=" . $worker['id'] . "'><img src='img/maintance/delete.png' style='width: 20px; height=20px;'></a></td>"; }
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <h2>Рабочий персонал</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Специальность</th>
                                <th>Зарплата</th>
                                <?php if($_SESSION['role'] === 'admin') { ?> <th></th> <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM users WHERE role = 'worker'";
                                $workers = mysqli_query($db, $query);
                                foreach($workers as $worker) {
                                    echo "<tr>";
                                    echo "<td>" . $worker['name'] . "</td>";
                                    echo "<td>" . $worker['speciality'] . "</td>";
                                    echo "<td>" . $worker['salary'] . "</td>";
                                    if($_SESSION['role'] === 'admin') { echo "<td><a href='actions/del_worker.php?id=" . $worker['id'] . "'><img src='img/maintance/delete.png' style='width: 20px; height=20px;'></a></td>"; }
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else {
            include("modules/unauthorized.php");
        }
    ?>
    <script src="script.js"></script>
</body>
</html>