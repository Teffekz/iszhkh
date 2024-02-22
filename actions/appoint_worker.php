<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $worker = $_POST['worker'];
        $work = $_GET['work'];
        $type = $_GET['type'];
        $sql = "INSERT INTO appointings (workid, workerid, type) VALUES ('$work', '$worker', '$type')";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../works_detailed.php?workid=<?php echo $work ?>&appointed=true";
                </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>