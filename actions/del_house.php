<?php session_start(); ?>
<?php include("../modules/db.php"); ?>
<link rel="stylesheet" href="../style.css">
<title>Удаление дома</title>

<?php
    if(isset($_SESSION['id'])) {
        $id = $_GET['id'];
        $id = intval($id);
        if(isset($_GET['confirm'])) {
            $query = "DELETE FROM housing WHERE id = $id";
            $result = mysqli_query($db, $query);
            if ($result) {
                ?>
                <script>
                    window.location.href = "../housing.php?deleted=true";
                </script>
                <?php
                exit;
            } else {
                echo "Error: " . mysqli_error($db);
            }
        } else {
            $query = "SELECT * FROM housing WHERE id = $id";
            $result = mysqli_query($db, $query);
            $house = mysqli_fetch_assoc($result); ?>
            <div class="center">
                <h1>Удаление дома</h1>
                <p>Вы уверены что хотите удалить этот дом?</p>
                <h3>Дом <? echo $house['number']?> улица <? echo $house['street']?>?</h3>
                <a href="../housing.php"><button class="scndbtn">Отмена</button></a>
                <a href="del_house.php?id=<?echo"$id"?>&confirm=true"><button class="basebtn">Удалить</button></a>
            </div>
        <?php }
    } else {
        include("../modules/unauthorized.php");
    }
?>