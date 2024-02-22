<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['reportType'])){
include("db.php");
    // Получаем тип отчета из данных формы
    $reportType = $_GET['reportType'];
    if(!empty($_GET['startdate'])) {
        $startdate = $_GET['startdate'];
        $enddate = $_GET['enddate'];
    }
    // Определяем SQL запрос в зависимости от выбранного типа отчета
    switch ($reportType) {
        case 'employees':
            $query = "SELECT name, speciality, salary FROM users";
            $querysum="SELECT SUM(salary) FROM users";
             break;
        case 'capital_repair':
            $query = "SELECT * FROM caprepairs";
            $querysum="SELECT SUM(cost) FROM caprepairs";
            if(isset($startdate)) {
                $query .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
                $querysum .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
            }
            break;
        case 'repairs':
            $query = "SELECT * FROM repairs";
            $querysum="SELECT SUM(cost) FROM repairs";
            if(isset($startdate)) {
                $query .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
                $querysum .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
            }
            break;
        case 'receipts':
            $query = "SELECT * FROM receipts";
            $querysum="SELECT SUM(cost) FROM receipts";
            if(isset($startdate)) {
                $query .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
                $querysum .= " WHERE date BETWEEN '$startdate' AND '$enddate'";
            }
            break;
            default:
            // Обработка неизвестного типа отчета
            die('Неверный тип отчета');
            
    }

    // Выполняем запрос к базе данных
    $result = mysqli_query($db,$query);

    $resultsum = mysqli_query($db, $querysum);
    $sumrow = mysqli_fetch_array($resultsum);
    $sum = $sumrow[0];

    // Проверяем результат
    if ($result) {
        if($reportType === 'employees') {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Имя</th>";
            echo "<th>Должность</th>";
            echo "<th>Зарплата</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['speciality'] . "</td>";
                echo "<td>" . $row['salary'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } elseif ($reportType === 'repairs') {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Порядковый номер</th>";
            echo "<th>Номер дома</th>";
            echo "<th>Улица</th>";
            echo "<th>Описание</th>";
            echo "<th>Стоимость</th>";
            echo "<th>Дата</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $houseid = $row['houseid'];
                $sql = "SELECT * FROM housing WHERE id = $houseid";
                $house_result = mysqli_query($db, $sql);
                $house = mysqli_fetch_assoc($house_result);
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $house['number'] . "</td>";
                echo "<td>" . $house['street'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['cost'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } elseif ($reportType === 'capital_repair') {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Порядковый номер</th>";
            echo "<th>Номер дома</th>";
            echo "<th>Улица</th>";
            echo "<th>Описание</th>";
            echo "<th>Стоимость</th>";
            echo "<th>Дата</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $houseid = $row['houseid'];
                $sql = "SELECT * FROM housing WHERE id = $houseid";
                $house_result = mysqli_query($db, $sql);
                $house = mysqli_fetch_assoc($house_result);
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $house['number'] . "</td>";
                echo "<td>" . $house['street'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['cost'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } elseif ($reportType === 'receipts') {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Порядковый номер</th>";
            echo "<th>Cумма</th>";
            echo "<th>Источник</th>";
            echo "<th>Дата</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['source'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
    } else {

        // Обработка ошибок запроса
        die('Ошибка запроса к базе данных');
    }
}
}