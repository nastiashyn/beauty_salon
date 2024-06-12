<?php
use Models\Master;


session_start();

use function Models\checkRegistered;
require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Додати майстра";
$type = "add";
$id = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (isset($_GET["type"])) {
        $type = $_GET["type"];
    }
}
if ($type == "edit")
    $name_page = "Редагувати майстра";

?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <?php
        $path = "../vendor/master/add.php";
        $btn_name = "Створити";
        if (isset($_GET["id"])) {
            $master = Master::Master($id);

            if ($type == "edit") {
                $btn_name = "Зберегти";
                $path = "../vendor/master/update.php?id=" . $master["id"];
            }
        }
        ?>
        <form action="<?= $path ?>" method="post" class="card">
            <div class="form-control">
                <label for="full_name">ПІБ:</label>
                <input type="text" name="full_name" value="<?= isset($_GET["id"]) ? $master["full_name"] : "" ?>">
            </div>
            <div class="form-control">
                <label for="phone">Телефон</label>
                <input type="phone" name="phone" value="<?= isset($_GET["id"]) ? $master["phone"] : "" ?>">
            </div>
            <div class="form-control">
                <label for="salary">Заробітна плата:</label>
                <input type="number" min="0" name="salary" value="<?= isset($_GET["id"]) ? $master["salary"] : "" ?>">
            </div>

            <div class="form-control">
                <label for="services_ids">Матеріали</label><!--Покищо без кількості-->
                <select class="multiple" name="services_ids[]" id="services_ids" multiple>
                    <?php
                    $services = Query::Services("default", "default", "default");
                    foreach ($services as $service) {
                        $check = "";
                        if (isset($_GET["id"])) {
                            foreach ($master['services'] as $s) {
                                if ($s["id"] == $service[0])
                                    $check = "selected";
                            }
                        }
                        ?>
                        <option value="<?= $service[0] ?>" <?= $check ?>>
                            <?= $service[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="submit">
                <?= $btn_name ?>
            </button>
            <button type="cancel" class="cancel">Скасувати</button>
        </form>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>