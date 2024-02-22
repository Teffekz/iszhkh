<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $id = $_POST['number'];
        $description = $_POST['description'];
        $cost = $_POST['cost'];

        $sql = "INSERT INTO repairs (houseid, description, cost) VALUES ($id, '$description', $cost)";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../repairs.php?created=true";
                </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>