<?php

session_start();

use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Додати матеріал на склад";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/material_storage/add.php" method="post" class="card">
            <div class="form-control">
                <label for="material_id">Матеріал:</label>
                <select name="material_id" id="material_id">
                    <?php
                    $materials = Query::Materials();
                    foreach ($materials as $material) {
                        ?>
                        <option value="<?= $material[0] ?>">
                            <?= $material[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-control">
                <label for="date">Дата:</label>
                <input type="date" name="date" id="date">
            </div>

            <div class="form-control">
                <label for="number">Кількість:</label>
                <input type="number" name="number">
            </div>

            <div class="form-control" style="margin-top:20px;">
                <p>Одиниця виміру: <i id="unit"></i></p>
            </div>
            <button type="submit" class="submit">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./scklad.php'">Скасувати</button>
        </form>
    </section>

    <script>

        $('#material_id').on('change', function () {
            LoadUnit(this.value);
        });
        function LoadUnit(material_id) {
            $.getJSON("../../vendor/ajax/material_unit.php?id="+material_id, function (resp) {

                console.log(resp.unit);
                document.getElementById("unit").innerText = resp.unit;

            });
        }


    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>