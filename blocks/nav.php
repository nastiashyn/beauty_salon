<nav>

    <?php
    if ($_SESSION['user']['role'] == "administrator") {
        ?>
        <ul>
            <li><a class="<?= ($name_page == "Календар") ? 'active' : '' ?>" href="./entry_schedule.php">Календар</a></li>
            <li><a class="<?= ($name_page == "Послуги") ? 'active' : '' ?>" href="./services.php">Послуги</a></li>
            <li><a class="<?= ($name_page == "Персонал") ? 'active' : '' ?>" href="./masters.php">Персонал</a></li>
            <li><a class="<?= ($name_page == "Склад") ? 'active' : '' ?>" href="./scklad.php">Склад</a></li>
            <li><a class="<?= ($name_page == "Фінанси") ? 'active' : '' ?>" href="./financial_accounting.php">Фінанси</a>
            </li>
            <li><a class="<?= ($name_page == "Клієнти") ? 'active' : '' ?>" href="./customer_base.php">Клієнти</a></li>
        </ul>
        <?php
    } else if ($_SESSION['user']['role'] == "master") {
        ?>
            <ul>
                <li><a class="<?= ($name_page == "Календар") ? 'active' : '' ?>" href="./entry_schedule.php">Календар</a></li>
                <li><a class="<?= ($name_page == "Послуги") ? 'active' : '' ?>" href="./services.php">Послуги</a></li>
                    <li><a class="<?= ($name_page == "Клієнти") ? 'active' : '' ?>" href="./customer_base.php">Клієнти</a></li>
            </ul>
        <?php
    } else if ($_SESSION['user']['role'] == "client") {
        ?>
                <ul>
                    <li><a class="<?= ($name_page == "Календар") ? 'active' : '' ?>" href="./entry_schedule.php">Календар</a></li>
                    <li><a class="<?= ($name_page == "Послуги") ? 'active' : '' ?>" href="./services.php">Послуги</a></li>
                    </li>
                </ul>
        <?php
    }
    ?>
</nav>