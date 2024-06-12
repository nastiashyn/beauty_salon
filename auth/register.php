<?php
session_start();


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkNotRegistered();
$name_page = "Реєстрація";
?>

<?php require '../blocks/head.php'; ?>


<body class="auth-body">

    <!-- Форма регистрации -->
    <div class="auth-form">
        <form action="../vendor/auth/signup.php" method="post" enctype="multipart/form-data">
            <label>Ім'я</label>
            <input type="text" name="full_name" placeholder="Введіть своє повне ім'я">
            <label>Логін</label>
            <input type="text" name="login" placeholder="Введіть логін">
            <label>Ел.пошта</label>
            <input type="email" name="email" placeholder="Введіть свою електрону адресу">
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введіть пароль">
            <label>Тип користувача</label>
            <select type="role" name="role">
                <!--<option value="administrator">Адміністратор</option>-->
                <option value="master">Майстер</option>
                <option value="client">Клієнт</option>
            </select>
            <label>Пітвердження пароля</label>
            <input type="password" name="password_confirm" placeholder="Підтвердіть пароль">
            <button class="btn" type="submit">Увійти</button>
            <p>
                Ви вже маєте акаунт? - <a href="/">авторизуйтесь</a>!
            </p>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
            ?>
        </form>
    </div>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>