<?php session_start(); ?>
<?php include("../modules/db.php"); ?>
<link rel="stylesheet" href="../style.css">
<title>Удаление работника</title>

<?php
    if(isset($_SESSION['id'])) {
        $id = $_GET['id'];
        $id = intval($id);
        if(isset($_GET['confirm'])) {
            $query = "DELETE FROM users WHERE id = $id";
            $result = mysqli_query($db, $query);
            if ($result) {
                ?>
                <script>
                    window.location.href = "../workers.php?deleted=true";
                </script>
                <?php
                exit;
            } else {
                echo "Error: " . mysqli_error($db);
            }
        } else {
            $query = "SELECT * FROM users WHERE id = $id";
            $result = mysqli_query($db, $query);
            $worker = mysqli_fetch_assoc($result); ?>
            <div class="center">
                <h1>Удаление работника</h1>
                <p>Вы уверены что хотите удалить этого работника?</p>
                <h3><? echo $worker['name']?></h3>
                <a href="../workers.php"><button class="scndbtn">Отмена</button></a>
                <a href="del_worker.php?id=<?echo"$id"?>&confirm=true"><button class="basebtn">Удалить</button></a>
            </div>
        <?php }
    } else {
        include("../modules/unauthorized.php");
    }
?>