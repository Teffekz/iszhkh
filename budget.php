<?php session_start(); ?>
<?php $cur_page = "budget"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Бюджет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) { ?>
            <div class="container">
                <? include("modules/menu.php"); ?>
                <div class="content">
                    <h1>Текущий бюджет:</h1>
                    <?php
                        $sql = "SELECT * FROM budget";
                        $result = mysqli_query($db, $sql);
                        $budget = mysqli_fetch_assoc($result);
                        
                    ?>
                    <h2 style="font-size: 46px"><?php echo number_format($budget['amount']) . " рублей"?></h2>
                    <div class="breaker"></div>
                    <h2>Последние поступления:</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Порядковый номер</th>
                                <th>Сумма</th>
                                <th>Источник</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM receipts ORDER BY id DESC LIMIT 5";
                                $receipts = mysqli_query($db, $query);
                                foreach($receipts as $receipt) {
                                    echo "<tr>";
                                    echo "<td>" . $receipt['id'] . "</td>";
                                    echo "<td>" . number_format($receipt['amount']) . "</td>";
                                    echo "<td>" . $receipt['source'] . "</td>";
                                    echo "<td>" . $receipt['date'] . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <a href="receipts.php"><button class="basebtn">Посмотреть все</button></a>
                    <div class="breaker"></div>
                    <h2>Должники:</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Номер квартиры</th>
                                <th>Номер дома</th>
                                <th>Улица</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM debtors";
                                $debtors = mysqli_query($db, $query);
                                while($debtor = mysqli_fetch_assoc($debtors)) {
                                    $houseid = $debtor['houseid'];
                                    $sql = "SELECT * FROM housing WHERE id = $houseid";
                                    $house_result = mysqli_query($db, $sql);
                                    $house = mysqli_fetch_assoc($house_result);
                                    echo "<tr>";
                                    echo "<td>" . $debtor['flat'] . "</td>";
                                    echo "<td>" . $house['number'] . "</td>";
                                    echo "<td>" . $house['street'] . "</td>";
                                    echo "<td>" . number_format($debtor['amount']) . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <a href="debtors.php"><button class="basebtn">Посмотреть всех</button></a>
                </div>
            </div>
        <?php } else {
            include("modules/unauthorized.php");
        }
    ?>
    <script src="script.js"></script>
</body>
</html>