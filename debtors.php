<?php session_start(); ?>
<?php $cur_page = "budget"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Должники</title>
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
                        <form class="authform" action="../actions/create_receipt.php" method="post">
                            <input required type="number" name="amount" placeholder="Сумма">
                            <select name="source">
                                <option selected disabled>Выберите источник</option>
                                <option value="Город">Город</option>
                                <option value="Население">Население</option>
                            </select>
                            <button id="createbtn" class="basebtn">Добавить</button>
                        </form>
                    </div>
                    <div class="flex">
                        <h1>Все должники:</h1>
                        <div class="plusbtn margleft" id="popup_activator"></div>
                    </div>
                    <?php if($_GET['created'] === 'true') { ?>
                        <div class="succes_message">
                            <p>Добавление прошло успешно</p>
                        </div>
                    <?php } ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Номер кваритры</th>
                                <th>Номер дома</th>
                                <th>Улица</th>
                                <th>Сумма</th>
                                <th></th>
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
                                    echo "<td></td>";
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