<?php session_start(); ?>
<?php $cur_page = "budget"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поступления</title>
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
                        <h1>Все поступления:</h1>
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
                                <th>Порядковый номер</th>
                                <th>Сумма</th>
                                <th>Источник</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM receipts";
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
                </div>
            </div>
        <?php } else {
            include("modules/unauthorized.php");
        }
    ?>
    <script src="script.js"></script>
</body>
</html>