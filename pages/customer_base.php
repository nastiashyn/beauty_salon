<?php

session_start();

use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Клієнтська база";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="customer_base">
        <button onclick="location.href='./add_client.php'">Додати</button>
        <div id="card" class="anticard"></div>
        <div class="card" id="table">
            <div id="table_"></div>
        </div>
    </section>
    <script>
        LoadData();
        function LoadData() {
            $.getJSON("../../vendor/ajax/clients.php", function (data) {
                PrintTable(data);
            });
        }
        function PrintTable(data) {

            const container = document.querySelector('#table_');
            console.log(data)
            if (data.length == 0) container.innerHTML = "<p style=\"text-align:center;color:darkgray;font-size:x-large;margin-top:100px\">Клієнтів не знайдено</p>";
            else {
                const hot = new Handsontable(container, {
                    data: data,
                    colHeaders: ['#', 'ПІБ', 'Дата народження', 'Телефон', 'Ел.адреса', 'Telegram', 'Instagram', 'Кількість сеансів', 'Майстри', 'Послуги'],
                    filters: true,
                    dropdownMenu: ['filter_by_condition', 'filter_by_value', 'filter_action_bar'],
                    readOnly: true,
                    width: '100%',
                    height: '100%',
                    stretchH: 'all',
                    colWidths: 100,
                    manualColumnResize: true,
                    autoWrapRow: true,
                    autoWrapCol: true,
                    licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only
                });
            }
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>