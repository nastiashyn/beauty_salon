<?php

session_start();


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
use function Models\checkRegistered;
checkRegistered();
$name_page = "Додати клієнта";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/client/add.php" method="post" class="card">
            <div class="form-control">
                <label for="full_name">ПІБ:</label>
                <input type="text" name="full_name">
            </div>
            <div class="form-control">
                <label for="date_of_birth">Дата народження:</label>
                <input type="date" name="date_of_birth">
            </div>
            <div class="form-control">
                <label for="email">Електрона пошта:</label>
                <input type="email" name="email">
            </div>
            <div class="form-control">
                <label for="phone">Телефон</label>
                <input type="phone" name="phone">
            </div>
            <div class="form-control">
                <label for="telegram">Телеграм:</label>
                <input type="text" name="telegram">
            </div>
            <div class="form-control">
                <label for="instagram">Інстаграм:</label>
                <input type="text" name="instagram">
            </div>
            <button type="submit" class="submit">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./customer_base.php'">Скасувати</button>
        </form>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>