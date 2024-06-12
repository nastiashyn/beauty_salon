<?php

session_start();
use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Редагування профілю";
if (isset($_GET["id"])) {

}
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/profile/add.php" method="post" class="card">

            <div class="form-control"><label for="full_name">ПІБ:</label><input type="text" name="full_name"></div>
            <div class="form-control"><label for="phone">Телефон:</label><input type="phone" name="phone"></div>
            <?php if (isset($_GET["id"])) { ?>
                <div class="form-control"><label for="name">Ім'я:</label><input type="text" name="name"></div>
            <?php } ?>
            <?php if (isset($_GET["id"])) { ?>
                <div class="form-control"><label for="login">Логін:</label><input type="text" name="login"></div>
            <?php } ?>
            <div class="form-control"><label for="email">Ел.адреса:</label><input type="email" value="<?= $_SESSION['user']['email']?>" name="email">
            </div>
            <?php if ($_SESSION['user']['role'] == 'master') { ?>
                <div class="form-control"><label for="status">Статус:</label>
                    <select name="status" id="status">
                        <option value="працює">Працюю</option>
                        <option value="у відпусці">У відпусці</option>
                    </select>
                </div>
            <?php } ?>
            <?php if ($_SESSION['user']['role'] == 'client') { ?>
                <div class="form-control"><label for="date_of_birth">Дата народження:</label><input type="date"
                        name="date_of_birth"></div><?php } ?>
            <?php if ($_SESSION['user']['role'] == 'client') { ?>
                <div class="form-control"><label for="telegram">Telegram:</label><input type="text" name="telegram"></div>
            <?php } ?>
            <?php if ($_SESSION['user']['role'] == 'client') { ?>
                <div class="form-control"><label for="instagram">Instagram:</label><input type="text" name="instagram">
                </div><?php } ?>
            <!--<div class="form-control"><label for="password">Пароль:</label><input type="password" name="password"></div>
            <div class="form-control"><label for="password2">Повторіть пароль:</label><input type="password"
                    name="password2"></div>-->
            <button type="submit" class="submit">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./main.php'">Скасувати</button>
        </form>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>