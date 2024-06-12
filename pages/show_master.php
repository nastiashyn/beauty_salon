<?php
use Models\Master;

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
            $master = Master::Master($id);

            ?>
            <h1>
                <?= $master["full_name"] ?>
            </h1>
            <!-- Інформація про послугу -->
            <div class="service-info">
                <p><strong>Статус:</strong>
                    <i>
                        <?= $master["status"] ?>
                    </i>
                </p>
                <p><strong>Телефон:</strong>
                    <?= $master["phone"] ?>
                </p>
                <p><strong>Зар.плата:</strong>
                    <?= $master["salary"] ?> грн
                </p>
                <p><strong>Прибуток за сеанси:</strong>
                    <?= $master["profit_from_seanses"] ?> грн
                </p>
                <p><strong>Послуги:</strong></p>

                <ul style="list-style:square;">
                    <?php
                    foreach ($master["services"] as $service) {
                        ?>
                        <li>
                            <?= $service["title"] . " - " . $service["price"] . " грн" ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <!-- Кнопки редагування та видалення -->
            <div class="action-buttons">
                <button onclick="location.href='masters.php'" class="">Повернутись</button>
                <button onclick="location.href='./add_employer.php?id=<?= $master['id'] ?>&type=edit'"
                    class="edit">Редагувати</button>
                <button onclick="location.href='../../vendor/master/delete.php?id=<?= $master['id'] ?>'"
                    class="delete">Видалити</button>
            </div>
        </div>
        </div>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>