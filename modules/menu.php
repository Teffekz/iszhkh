<style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
</style>
<div class="menu">
    <ul>
        <a href="index.php"><li <?php if($cur_page === "profile") {echo 'class="activeItem"';} ?>>Профиль</li></a>
        <a href="housing.php"><li <?php if($cur_page === "housing") {echo 'class="activeItem"';} ?>>Жилой фонд</li></a>
        <a href="workers.php"><li <?php if($cur_page === "workers") {echo 'class="activeItem"';} ?>>Работники</li></a>
        <?php if ($_SESSION['role']==="admin" || $_SESSION['role']==="engineer"){ ?><a href="caprepairs.php"><li <?php if($cur_page === "caprepairs") {echo 'class="activeItem"';} ?>>Капитальный ремонт</li></a><?php } ?>
        <?php if ($_SESSION['role']==="admin" || $_SESSION['role']==="accountant"){ ?><a href="report.php"><li <?php if($cur_page === "report") {echo 'class="activeItem"';} ?>>Отчётность</li></a><?php } ?>
        <?php if ($_SESSION['role']==="admin" || $_SESSION['role']==="engineer"){ ?><a href="repairs.php"><li <?php if($cur_page === "repairs") {echo 'class="activeItem"';} ?>>Ремонтные работы</li></a><?php } ?>
        <?php if ($_SESSION['role']==="admin" || $_SESSION['role']==="accountant"){ ?><a href="budget.php"><li <?php if($cur_page === "budget") {echo 'class="activeItem"';} ?>>Бюджет</li></a><?php } ?>
    </ul>
</div>