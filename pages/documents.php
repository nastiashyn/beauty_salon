<?php

session_start();
use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Фінансовий облік";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="documents">
        <div class="anticard" id="buttons">
            <button>Імпортувати документ</button>
        </div>
        <div class="card" id="documents_list">
            <div class="anticard-sm" id="filter">
                <button class="tag">#tag1</button>
                <button class="tag">#tag2</button>
                <button class="tag">#tag3</button>
            </div>
            <div class="anticard-sm">
                <?php
                for ($i = 0; $i < 10; $i++) {
                    ?>
                    <div class="card-sm document-item">
                        <h5>Файл #
                            <?= $i ?>
                        </h5>
                        <p class="date" title="Дата створення файлу">22.02.2003</p>
                        <p class="date" title="Дата завантаження файлу">22.02.2003</p>
                        <div class="tags">
                            <a href="#" class="tag">#tag1</a>
                            <a href="#" class="tag">#tag2</a>
                            <a href="#" class="tag">#tag3</a>
                        </div>
                        <div class="options">
                            <button onclick="" title="Скачати" class="download icon"><ion-icon
                                    name="download"></ion-icon></button>
                            <button onclick="" title="Друкувати" class="print icon"><ion-icon
                                    name="print"></ion-icon></button>
                            <button onclick="" title="Видалити" class="delete icon"><ion-icon
                                    name="trash"></ion-icon></button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>