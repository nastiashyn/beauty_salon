<?php
use Models\Service;

session_start();
use function Models\checkRegistered;



require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Послуги";
?>
<?php require '../blocks/head.php'; ?>

<body>

    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="service">
        <div class="card">
            <?php
            $id = $_GET["id"];
            $service = Service::Service($id);
            ?>
            <h1>
                <?= $service["title"] ?>
            </h1>
            <!-- Інформація про послугу -->
            <div class="service-info">
                <p style="margin-bottom:15px;margin-top:-10px;"><i>
                        <?= $service["description"] ?>
                    </i></p>
                <p><strong>Ціна:</strong>
                    <?= $service["price"] ?> грн
                </p>
                <p><strong>Майстри:</strong>
                    <?= $service["masters"] ?>
                </p>
                <p><strong>Матеріали:</strong></p>
                <?php

                if ( count($service["materials"]) === 0) { ?>
                    <small style="color: red;">Матерілів до послуги не записано</small>
                    <?php
                } else {
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Назва</th>
                                <th>Ціна</th>
                                <th>Кількість для послуги</th>
                                <th>Кількість на складі</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($service["materials"] as $material) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $material["title"] ?>
                                    </td>
                                    <td>
                                        <?= $material["price"] ?> грн
                                    </td>
                                    <td>
                                        <?= $material["number"] . " " . $material["unit"] ?>
                                    </td>
                                    <td>
                                        <?= $material["number_on_storage"] . " " . $material["unit"] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>

            <!-- Кнопки редагування та видалення -->
            <div class="action-buttons">
                <button onclick="location.href='services.php'" class="">Повернутись</button>
                <button onclick='location.href = "./add_service.php?id=<?= $id ?>&type=edit"'
                    class="edit">Редагувати</button>
                <button onclick="location.href='../../vendor/service/delete.php?id=<?= $id ?>'"
                    class="delete">Видалити</button>
            </div>
        </div>
        </div>
    </section>
    <script>
        //------------------------------------DOCUMENT READY------------------------------------
        document.addEventListener("DOMContentLoaded", function (event) {

        });
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>