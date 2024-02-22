<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $num = $_POST['number'];
        $street = $_POST['street'];
        $sql = "INSERT INTO housing (number, street) VALUES ('$num', '$street')";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../housing.php?created=true";
                </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>