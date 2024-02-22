<?php session_start(); ?>
<?php $cur_page = "caprepairs"; ?>
<?php include("modules/db.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Капитальный ремонт</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) { ?>
            <div class="container">
                <? include("modules/menu.php"); ?>
                <div class="content">
                    <div id="popup" class="center hidden">
                        <div id="popup_closer"><p>X</p></div>
                        <form class="authform" action="../actions/create_caprepair.php" method="post">
                            <select name="street" id="street">
                                <option value="" selected disabled>Выберите улицу</option>
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
                                $('#street').change(function() {
                                    var street = $(this).val();
                                
                                    $.ajax({
                                        url: 'ajax/get_houses.php',
                                        type: 'GET',
                                        data: { street: street },
                                        success: function(response) {
                                            $('#number').html(response);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Ошибка запроса. Статус:', xhr.status);
                                        }
                                    });
                                });
                            </script>
                            <input type="text" placeholder="Описавние работы" name="description">
                            <input type="date" name="date">
                            <input type="text" placeholder="Стоимость работы" name="cost">
                            <button class="basebtn">Добавить</button>
                        </form>
                    </div>
                    <div class="flex">
                        <h1>Капитальный Ремонт</h1>
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
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM caprepairs";
                                $repairs = mysqli_query($db, $query);
                                foreach ($repairs as $repair) {
                                    $houseid = $repair['houseid'];
                                    $query = "SELECT number, street FROM housing WHERE id = $houseid";
                                    $houseResult = mysqli_query($db, $query);
                                    $house = mysqli_fetch_assoc($houseResult);
                                    
                                    echo "<tr>";
                                    echo "<td><a href='capworks_detailed.php?workid=" . $repair['id'] . "'>" . $house['number'] . "</a></td>";
                                    echo "<td>" . $house['street'] . "</td>";
                                    echo "<td>" . $repair['description'] . "</td>";
                                    echo "<td>" . $repair['date'] . "</td>";
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