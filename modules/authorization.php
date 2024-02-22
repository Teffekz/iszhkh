<div class="center">
    <form class="authform" action="../actions/auth.php" method="post">
        <h1>Войдите в систему</h1>
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="pass" placeholder="Пароль">
        <?php
            if($_GET['error'] === 'true') { ?>
                <p style="color: red">Неверный логин или пароль</p>
            <?php }
        ?>
        <button class="basebtn">Войти</button>
    </form>
</div>