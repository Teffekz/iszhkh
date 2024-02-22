<?php session_start(); ?>
<?php $cur_page = "housing"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Жилой фонд</title>
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
                        <form class="authform" action="../actions/create_house.php" method="post">
                            <input type="text" name="number" placeholder="Номер">
                            <input type="text" name="street" placeholder="Улица">
                            <button class="basebtn">Добавить</button>
                        </form>
                    </div>
                    <div class="flex">
                        <h1>Жилой Фонд</h1>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Номер</th>
                                <th>Улица</th>
                                <?php if($_SESSION['role'] === 'admin') { ?> <th style="width: 100px"></th> <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM housing";
                                $housing = mysqli_query($db, $query);
                                foreach($housing as $house) {
                                    echo "<tr>";
                                    echo "<td>" . $house['number'] . "</td>";
                                    echo "<td>" . $house['street'] . "</td>";
                                    if($_SESSION['role'] === 'admin')
                                    { 
                                        echo "<td><a href='actions/del_house.php?id=" . $house['id'] . "'><img src='img/maintance/delete.png' style='width: 20px; height=20px;'></a></td>"; 
                                    }
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