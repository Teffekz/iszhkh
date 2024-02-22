<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $worker = $_SESSION['id'];
        $work = $_GET['work'];
        $sql = "UPDATE appointings SET status = 'done' WHERE workid = $work AND workerid = $worker";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../index.php?reported=true";
                </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>