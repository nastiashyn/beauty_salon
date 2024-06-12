<?php
use Models\Client;
use Models\Master;
use Models\Query;

session_start();

require_once 'C:\Users\Julie\source\beauty_salon\blocks\models.php'; 

use function Models\checkRegistered;
checkRegistered();
$name_page = "Послуги";
?>
<?php require '../blocks/head.php'; ?>

<body>

    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="service">
        <div class="card">
            <h1>
                <?= $_SESSION['user']['full_name'] ?>
            </h1>
            <!-- Інформація про послугу -->
            <div class="service-info">
                <p><strong>Логін:</strong>
                    <?= $_SESSION['user']['login'] ?>
                </p>
                <p><strong>Ел.адреса:</strong>
                    <?= $_SESSION['user']['email'] ?>
                </p>
                <?php
                if ($_SESSION['user']['role'] == "master" && $_SESSION['user']['master_id'] != null) {
                    $master = Master::Master($_SESSION['user']['master_id']);

                    ?>
                    <p><strong>ПІБ:</strong>
                        <?= $master['full_name'] ?>
                    </p>
                    <p><strong>Статус:</strong>
                        <?= $master['status'] ?>
                    </p>
                    <p><strong>Номер тел.:</strong>
                        <?= $master['phone'] ?>
                    </p>
                    <p><strong>Зар.плата:</strong>
                        <?= $master['salary'] . " грн" ?>
                    </p>
                    <?php
                } else if ($_SESSION['user']['role'] == "master" && $_SESSION['user']['master_id'] == null) {
                    ?>
                        <p style="color:orangered;">
                            Немає даних про вас як майстра (<a style="color:orangered;text-decoration:none;"
                                href="./add_profile.php">Додати</a>)
                        </p>
                    <?php

                } else if ($_SESSION['user']['role'] == "client" && $_SESSION['user']['client_id'] != null) {

                    $client = Client::Client($_SESSION['user']['client_id']);

                    ?>
                            <p><strong>ПІБ:</strong>
                        <?= $client['full_name'] ?>
                            </p>
                            <p><strong>Дата народження:</strong>
                        <?= $client['date_of_birth'] ?>
                            </p>
                            <p><strong>Номер тел.:</strong>
                        <?= $client['phone'] ?>
                            </p>
                            <p><strong>Ел.адреса:</strong>
                        <?= $client['email'] ?>
                            </p>
                            <p><strong>Telegram:</strong>
                        <?= $client['telegram'] ?>
                            </p>
                            <p><strong>Instagram:</strong>
                        <?= $client['instagram'] ?>
                            </p>
                    <?php
                } else if ($_SESSION['user']['role'] == "client" && $_SESSION['user']['client_id'] == null) {
                    ?>
                                <p style="color:orangered;">
                                    Немає даних про вас як клієнта (<a style="color:orangered;text-decoration:none;"
                                        href="./add_profile.php">Додати</a>)
                                </p>
                    <?php

                }
                ?>


            </div>

            <!-- Кнопки редагування та видалення -->
            <div class="action-buttons">
                <button onclick="location.href='./add_profile.php?id=<?= $_SESSION['user']['id'] ?>'"
                    class="edit">Редагувати</button>
                <button onclick="DeleteProfile()" class="delete">Видалити акаунт</button>
            </div>
        </div>
        </div>
    </section>
    <script>
        function DeleteProfile() {
            let res = confirm("Ви впевнені?");
            if (res) location.href = "../vendor/profile/delete.php";
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>