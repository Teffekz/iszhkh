<?php session_start(); ?>
<?php $cur_page = "report"; ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Отчётность</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_SESSION['id'])) {?>
        <div class="container">
            <? include("modules/menu.php"); ?>
            <div class="content">
                <div class="flex">
                    <h1>Сформировать отчёт</h1>
                    <form class="flex" method="get" action="">
                        <select style="margin-top: 0px;" name="reportType" id="reportType">
                            <option selected disabled value="employees">Выберите тип отчёта</option>
                            <option value="employees">Отчет по работникам</option>
                            <option value="capital_repair">Отчет по капитальному ремонту</option>
                            <option value="repairs">Отчет по ремонтным работам</option>
                            <option value="receipts">Отчет по денежным поступлениям</option>
                        </select>
                        <h1 class="margleft" for="startdate">С:</h1>
                        <input type="date" name="startdate">
                        <h1 class="margleft">По:</h1>
                        <input type="date" name="enddate">
                        <button class="basebtn margleft">Сформировать</button>
                    </form>
                </div>
            <div>
            <?php
                include "modules/report-form.php";
            ?>                
        </div>
    <?php } ?>
</body>

</html>
