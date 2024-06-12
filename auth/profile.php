<?php
session_start();

require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkNotRegistered();
$name_page = "Ви увійшли";
?>
<?php require '../blocks/head.php'; ?>

<body>

    <!-- Профиль -->

    <h1>
        <?= $name_page ?>
    </h1>
    <form>
        <h2 style="margin: 10px 0;"><?= $_SESSION['user']['full_name'] ?></h2>
        <a href="#"><?= $_SESSION['user']['email'] ?></a>
        <a href="vendor/logout.php" class="logout">Вихід</a>
    </form>

</body>

</html>