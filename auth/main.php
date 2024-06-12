<?php
session_start();
require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php'; 
use function Models\checkNotRegistered;


checkNotRegistered();


$name_page = "Увійти";
?>
<?php require '../blocks/head.php'; ?>

<body class="auth-body">

    <!-- Форма авторизации -->
    <div class="auth-form">
        <form action="../vendor/auth/signin.php" method="post">

            <h1>
                <?= $name_page ?>
            </h1>
            <label>Логін</label>
            <input type="text" name="login" placeholder="Введите свой логин">
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль">
            <button class="btn" type="submit">Увійти</button>
            <p>
                Немаєте акаунту? - <a href="./register.php">зареєструйтесь</a>!
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