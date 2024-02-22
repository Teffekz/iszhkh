<?php
    session_start();
    include("../modules/db.php");

    $login = $_POST['login'];
    $password = $_POST['pass'];

    $query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['speciality'] = $user['speciality'];

        ?>
            <script>
                 window.location.href = "../index.php";
            </script>
        <?php
        exit;
    } else {
        ?>
            <script>
                 window.location.href = "../index.php?error=true";
            </script>
        <?php
        exit;
    }
?>