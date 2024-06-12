<?php


session_start();
use function Models\checkRegistered;

require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Додаваня витрати чи доходу";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/finance/add.php" method="post" class="card">
            <div class="form-control">
                <label for="type">Тип:</label>
                <select name="type" id="type">
                    <option value="">Оберіть тип</option>
                    <option value="Витрати">Витрати</option>
                    <option value="Дохід">Дохід</option>
                </select>
            </div>
            <div class="form-control">
                <label for="date">Дата:</label>
                <input type="date" name="date">
            </div>
            <div class="form-control">
                <label for="sum">Сума:</label>
                <input type="number" min="0" step=".01" name="sum">
            </div>
            <div class="form-control">
                <label for="category">Категорія</label>
                <select name="category" id="category">
                    <option value="Інше">Оберіть категорію</option>
                    <option value="Оренда">Оренда</option>
                    <option value="Комунальні послуги">Комунальні послуги</option>
                    <option value="Інше">Інше</option>
                </select>
            </div>
            <button type="submit" class="submit">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./financial_accounting.php'">Скасувати</button>
        </form>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>