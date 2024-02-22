<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $amount = $_POST['amount'];
        $source = $_POST['source'];

        $query = "SELECT amount FROM budget LIMIT 1";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $currentAmount = $row['amount'];

        $newAmount = $currentAmount + $amount;

        $updateQuery = "UPDATE budget SET amount = $newAmount";
        $updateResult = mysqli_query($db, $updateQuery);

        $insertQuery = "INSERT INTO receipts (amount, source, date) VALUES ($amount, '$source', NOW())";
        $insertResult = mysqli_query($db, $insertQuery);

        if($insertResult && $updateResult) {
            ?>
                <script>
                    window.location.href = "../receipts.php?created=true";
                </script>
            <?php
        }
    } else {
        include("../modules/unauthorized.php");
    }
?>