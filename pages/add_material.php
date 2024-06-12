<?php

session_start();
use function Models\checkRegistered;



require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Додати новий матеріал";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/material/add.php" method="post" class="card">
            <div class="form-control">
                <label for="title">Назва:</label>
                <input type="title" name="title" id="title">

            </div>
            <div class="form-control">
                <label for="description">Опис:</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-control">
                <label for="days_number_expiration">Термін зберігання (у днях):</label>
                <input type="number" min="1" name="days_number_expiration" id="days_number_expiration">
            </div>

            <div class="form-control">
                <label for="unit">Одиниця виміру:</label>
                <input type="text" name="unit" id="unit">
            </div>

            <div class="form-control">
                <label for="number_for_price">Кількість:</label>
                <input type="number" min="1" name="number_for_price" id="number_for_price">
            </div>
            <div class="form-control">
                <label for="material_price">Ціна (за вказану кількість):</label>
                <input type="number" min="1" name="material_price" id="material_price">
            </div>
            <button type="submit" class="submit">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./scklad.php'">Скасувати</button>
        </form>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>