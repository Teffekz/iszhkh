<?php session_start(); ?>
<?php $cur_page = "repairs"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ремонтные работы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])&&$_SESSION['role']==='admin' || $_SESSION['role']==='engineer') { ?>
            <div class="container">
                <? include("modules/menu.php"); ?>
                <div class="content">
                    <div id="popup" class="center hidden">
                        <div id="popup_closer"><p>X</p></div>
                        <form class="authform" action="../actions/create_repair.php" method="post">
                            <select name="street" id="street">
                                <option selected disabled value="">Выберите улицу</option>
                                <?php
                                    $sql = "SELECT DISTINCT street FROM housing";
                                    $result = mysqli_query($db, $sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['street'] . "'>" . $row['street'] . "</option>";
                                    }                                
                                ?>
                            </select>
                            <select name="number" id="number">
                                <option selected disabled value="">Сначала выберите улицу</option>
                            </select>
                            <script>
                                document.getElementById('street').addEventListener('change', function() {
                                    var street = this.value;
                                    var xhttp = new XMLHttpRequest();

                                    xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4) {
                                            if (this.status == 200) {
                                                var houseSelect = document.getElementById('number');
                                                houseSelect.innerHTML = this.responseText;
                                            } else {
                                                console.error('Ошибка запроса. Статус:', this.status);
                                            }
                                        }
                                    };
                                    xhttp.open('GET', 'ajax/get_houses.php?street=' + street, true);
                                    xhttp.send();
                                });
                            </script>
                            <input type="textarea" placeholder="Описавние работы" name="description">
                            <input type="text" placeholder="Стоимость работы" name="cost">
                            <button class="basebtn">Добавить</button>
                        </form>
                    </div>
                    <div class="flex">
                            <h1>Ремонтные работы</h1>
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
                                <th>Номер</th>
                                <th>Улица</th>
                                <th>Описание работы</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM repairs";
                                $repairs = mysqli_query($db, $query);
                                while ($repair = mysqli_fetch_assoc($repairs)) {
                                    $status = "Ожидает назначения";
                                    $workid = $repair['id'];
                                    $houseid = $repair['houseid'];
                                    $query = "SELECT number, street FROM housing WHERE id = $houseid";
                                    $houseResult = mysqli_query($db, $query);
                                    $house = mysqli_fetch_assoc($houseResult);
                                    $sql = "SELECT * FROM appointings WHERE workid = $workid";
                                    $result = mysqli_query($db, $sql);
                                    if(mysqli_num_rows($result) >= 1) {
                                        $status = "Выполнено";
                                        foreach($result as $appointing) {
                                            if($appointing['status'] === "waiting") {
                                                $status = "Ожидает выполнения";
                                            }
                                        }
                                    }
                                    echo "<tr>";
                                    echo "<td><a href='works_detailed.php?workid=" . $repair['id'] . "'>" . $house['number'] . "</a></td>";
                                    echo "<td>" . $house['street'] . "</td>";
                                    echo "<td>" . $repair['description'] . "</td>";
                                    echo "<td>" . $status . "</td>";

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