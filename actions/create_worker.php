<?php session_start(); ?>
<?php include("../modules/db.php"); ?>

<?php
    if(isset($_SESSION['id'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $sql="SELECT login FROM users where login=?";
        $result = $db->prepare($sql);
        $result->bind_param("s", $login);
        $result->execute();
        $result= $result->get_result();
        if($result->num_rows ) {
            echo "<script>window.location.href='http://w9635422.beget.tech/workers.php';</script>";
            die();
        } else {  
        if(isset($_POST['role'])) {
            $role = $_POST['role'];
        } else {
            $role = 'worker';
        }
        if(isset($_POST['speciality'])) {
            $speciality = $_POST['speciality'];
        } else {
            $speciality = NULL;
        }
        if(isset($_POST['salary'])) {
            $salary = $_POST['salary'];
        } else {
            $salary = NULL;
        }
    

        $name = $_POST['name'];
        $sql = "INSERT INTO users (login, password, name, role, speciality, salary) VALUES ('$login', '$password', '$name', '$role', '$speciality', '$salary')";
        $result = mysqli_query($db, $sql);
        if($result) {
            ?>
                <script>
                    window.location.href = "../workers.php?created=true";
                </script>
            <?php
        } else {
        
            echo "Error: " . mysqli_error($db);
        }
        
    }} else {
        include("../modules/unauthorized.php");
    }
?>