<?php
use Models\Master;
use Models\Material;
use Models\Service;
session_start();


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
use function Models\checkRegistered;

checkRegistered();
$type = "add";
$id = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (isset($_GET["type"])) {
        $type = $_GET["type"];
    }
}

$name_page = "Додати послугу";

if ($type == "edit")
    $name_page = "Редагувати послугу";
else if ($type == "copy")
    $name_page = "Копіювати послугу";

?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="add_services">
        <?php
        $path = "../vendor/service/add.php";
        $btn_name = "Створити";
        if (isset($_GET["id"])) {
            $service = Service::Service($id);

            if ($type == "edit") {
                $btn_name = "Зберегти";
                $path = "../vendor/service/update.php?id=" . $service["id"];
            } else if ($type == "copy") {
                $btn_name = "Створити копію";
                $path = "../vendor/service/add.php";

            }
        }
        ?>
        <form action="<?= $path ?>" method="post" class="card">
            <div class="form-control">
                <label for="name">Назва:</label>
                <input type="text" name="name" value="<?= isset($_GET["id"]) ? $service["title"] : "" ?>">
            </div>
            <div class="form-control">
                <label for="price">Ціна:</label>
                <input type="number" min="0" name="price" value="<?= isset($_GET["id"]) ? $service["price"] : "" ?>">
            </div>
            <div class="form-control">
                <label for="master_ids">Майстри</label>
                <select class="multiple" name="master_ids[]" id="master_ids" multiple <?= $_SESSION["user"]["master_id"] != null ? "disabled" : "" ?>>
                    <?php
                    $employee = Master::Masters();
                    foreach ($employee as $employer) {
                        $check = "";
                        if ($_SESSION["user"]["master_id"] != null) {
                            if ($_SESSION["user"]["master_id"] == $employer[0])
                                $check = "selected";
                        }
                        if (isset($_GET["id"])) {
                            foreach ($service['masters_arr'] as $e) {

                                if ($e[0] == $employer[0])
                                    $check = "selected";
                            }
                        }
                        ?>
                        <option value="<?= $employer[0] ?>" <?= $check ?>>
                            <?= $employer[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-control">
                <label for="description">Опис:</label>
                <textarea style="height: -webkit-fill-available;" type="description" name="description"
                    value="<?= isset($_GET['id']) ? $service['description'] : '' ?>" col="20" row="1"></textarea>
            </div>
            <div class="form-control">
                <label for="time">Час:</label>
                <input type="number" min="0" name="time" value="<?= isset($_GET['id']) ? $service['time'] : '' ?>">
            </div>
            <div class="form-control">
                <label for="material_id">Матеріали:</label><!--Покищо без кількості-->
                <select class="" name="material_id" id="material_id">
                    <?php
                    $materials = Material::Materials();
                    foreach ($materials as $material) {
                        $check = "";
                        if (isset($_GET["id"])) {
                            foreach ($service['materials'] as $m) {
                                if ($m[0] == $material[0])
                                    $check = "selected";
                            }
                        }
                        ?>
                        <option value="<?= $material[0] ?>" <?= $check ?>>
                            <?= $material[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <button type="button" class="add" onclick="AddToMaterialsList()">Додати у список</button>

                <div id="materialsList">
                    <div class="row" style="width:100%;border-bottom:1px solid black;">
                        <p style="margin-bottom:3px;width:40%">Назва</p>
                        <p style="margin-bottom:3px;width:32%">К-сть</p>
                        <p style="margin-bottom:3px;width:20%">Од.вим.</p>
                        <p style="margin-bottom:3px;width:8%"></p>
                    </div>
                    <!-- Тут буде додаватися список матеріалів динамічно -->
                </div>
            </div>

            <button type="submit" class="submit">
                <?= $btn_name ?>
            </button>
            <button type="button" class="cancel" onclick="location.href='./customer_base.php'">Скасувати</button>
        </form>
    </section>
    <script>
        function AddToMaterialsList() {
            let value = document.getElementById("material_id").value;
            $.getJSON("../../vendor/ajax/material.php?id=" + value, function (resp) {

                let materialsList = document.getElementById("materialsList");
                var elem = document.createElement('div');
                elem.className = 'row';

                var inputMaterial = document.createElement('input');
                inputMaterial.type = 'number';
                inputMaterial.name = 'materials[]';
                inputMaterial.style = 'visible:invisible;';
                inputMaterial.value = resp.id;
                elem.appendChild(inputMaterial);

                var inputMaterial = document.createElement('input');
                inputMaterial.type = 'text';
                inputMaterial.name = 'materials_[]';
                inputMaterial.readOnly = 'true';
                inputMaterial.style = 'width:35%';
                inputMaterial.value = resp.title;
                elem.appendChild(inputMaterial);

                var inputNumber = document.createElement('input');
                inputNumber.type = 'number';
                inputNumber.name = 'numbers[]';
                inputNumber.style = 'width:32%';
                elem.appendChild(inputNumber);

                var inputUnit = document.createElement('input');
                inputUnit.type = 'text';
                inputUnit.style = 'width:20%';
                inputUnit.name = 'units[]';
                inputUnit.readOnly = 'true';

                inputUnit.value = resp.unit == "" ? "(не вказано)" : resp.unit;
                elem.appendChild(inputUnit);

                var btn = document.createElement('button');
                btn.className = 'btn';
                btn.type = 'button';
                btn.style = 'width:8%';
                btn.textContent = 'X';
                btn.onclick = function () {
                    DeleteFromMaterialsList(this);
                };
                elem.appendChild(btn);

                materialsList.appendChild(elem);
            });
        }
        function DeleteFromMaterialsList(elem) {
            elem.parentElement.remove();
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>