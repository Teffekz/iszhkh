<?php session_start(); ?>
<?php $workid = $_GET["workid"]; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ремонтная работа №</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) { ?>
            <div class="container">
              <? include("modules/menu.php"); ?>
              <div class="content">
                <?php 
                    if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'engineer') { ?>
                        <div id="popup" class="center hidden">
                            <div id="popup_closer"><p>X</p></div>
                            <form class="authform" action="../actions/appoint_worker.php?work=<?php echo $workid; ?>&type=repair" method="post">
                                <select name="worker">
                                    <option selected disabled value="">Выберите работника</option>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE role = 'worker'";
                                        $result = mysqli_query($db, $sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }                                
                                    ?>
                                </select>
                                <button class="basebtn">Добавить</button>
                            </form>
                        </div>
                    <?php } ?>
                <?php if($_GET['appointed'] === 'true') { ?>
                        <div class="succes_message">
                            <p>Назначение прошло успешно</p>
                        </div>
                    <?php } ?>
                <h1>Ремонтная работа №<?php echo $workid ?></h1>
                <?php
                    $sql = "SELECT * FROM repairs WHERE id = $workid";
                    $result = mysqli_query($db, $sql);
                    if(mysqli_num_rows($result) === 1) {
                        $work = mysqli_fetch_assoc($result);
                        $houseid = $work['houseid'];
                        $sql = "SELECT * from housing WHERE id = $houseid";
                        $result = mysqli_query($db, $sql);
                        if(mysqli_num_rows($result) === 1) {
                            $house = mysqli_fetch_assoc($result);
                            $street = $house['street'];
                            $num = $house['number'];
                        }
                    }
                ?>
                <h2>Адрес:</h2>
                <p>ул. <?php echo $street ?>, д. <?php echo $num?></p>
                <h2>Описание работы:</h2>
                <p><?php echo $work['description'] ?></p>
                <h2>Назначенные работники:</h2>
                <?php
                    $sql = "SELECT * FROM appointings WHERE workid = $workid AND type = 'repair'";
                    $result = mysqli_query($db, $sql);
                                
                    if(mysqli_num_rows($result) >= 1) {
                        while($appoint = mysqli_fetch_assoc($result)) {
                            $workerid = $appoint['workerid'];
                            $sql = "SELECT * FROM users WHERE id = $workerid";
                            $worker = mysqli_query($db, $sql);
                        
                            if(mysqli_num_rows($worker) === 1) {
                                $worker = mysqli_fetch_assoc($worker);
                                echo "<p>" . $worker['name'] . "</p>";
                            }
                        }
                    } else {
                        echo "На эту работу пока никто не назначен";
                    }
                    if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'engineer') { ?>
                    <button id="popup_activator" class="basebtn">Назначить</button>
                    <?php }
                    if($_SESSION['role'] === 'worker') { ?>
                        <a href="actions/work_report.php?work=<?php echo $workid ?>"><button class="basebtn">Отчитаться о выполнении</button></a>
                    <?php } ?>
              </div>
            </div>            
        <?php }
        else {
            include("modules/unauthorized.php");
        }
    ?>
    <script src="script.js"></script>
</body>
</html>