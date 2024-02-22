<?php session_start(); ?>
<?php $cur_page = "profile"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ИС УК ЖКХ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id']; ?>
            <div class="container">
              <? include("modules/menu.php"); ?>
              <div class="content">
                <div class="flex between">
                    <h1><?echo $_SESSION['name']?></h1>
                    <a href="actions/logout.php"><button class="scndbtn">Выйти из системы</button></a>
                </div>
                <h2>Роль: <?php echo $_SESSION['role'] ?></h2>
                <h2>Должность: <?php echo $_SESSION['speciality'] ?></h2>
                <?php
                    if($_SESSION['role'] === 'worker') {
                        echo "<div class='breaker'></div>";
                        echo '<h2>Активные работы</h2>';
                        $sql = "SELECT * FROM appointings WHERE workerid = $userid AND status = 'waiting' AND type = 'repair'";
                        $result = mysqli_query($db, $sql);
                        if (mysqli_num_rows($result) >= 1) {
                            while ($appoint = mysqli_fetch_assoc($result)) {
                                $workid = $appoint['workid'];
                                $sql = "SELECT * FROM repairs WHERE id = $workid";
                                $result = mysqli_query($db, $sql);
                                $work = mysqli_fetch_assoc($result);
                                $houseid = $work['houseid'];
                                $sql = "SELECT * FROM housing WHERE id = $houseid";
                                $result = mysqli_query($db, $sql);
                                $house = mysqli_fetch_assoc($result); ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Номер</th>
                                            <th>Улица</th>
                                            <th>Описание работы</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                echo "<tr>";
                                                echo "<td><a href='works_detailed.php?workid=" . $work['id'] . "'>" . $house['number'] . "</a></td>";
                                                echo "<td>" . $house['street'] . "</td>";
                                                echo "<td>" . $work['description'] . "</td>";
                                                echo "</tr>";
                                        ?>
                                    </tbody>
                                </table>
                            <?php }
                        } else {
                            echo "<p>На данный момент вам не назначено работ.</p>";
                        }
                    }
                ?>
              </div>
            </div>            
        <?php }
        else {
            include("modules/authorization.php");
        }
    ?>
</body>
</html>