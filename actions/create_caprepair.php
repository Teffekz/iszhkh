<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $id = $_POST['number'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $cost = $_POST['cost'];


        $sql = "INSERT INTO caprepairs (houseid, description, date, cost) VALUES ($id, '$description', '$date', $cost)";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../caprepairs.php?created=true";
                </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>