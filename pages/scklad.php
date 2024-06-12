<?php

session_start();
use function Models\checkRegistered;



require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Склад";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="scklad">

        <div class="card" id="table">
            <button onclick="location.href='add_material_on_storage.php'">Закупити матеріал</button>
            <button onclick="location.href='add_material.php'">Додати новий матеріал</button>
            <div id="table_"></div>
        </div>
    </section>
    <script>
        let data = [];
        const container = document.querySelector('#table_');
        //------------------------------------DOCUMENT READY------------------------------------
        document.addEventListener("DOMContentLoaded", function (event) {
            LoadData();
        });
        //------------------------------------LOAD DATA------------------------------------
        function LoadData() {
            $.getJSON("../../vendor/ajax/storage.php", function (resp) {
                data = resp.data;
                PrintData();
            });
        }
        //------------------------------------PRINT DATA------------------------------------
        function PrintData() {
            const hot = new Handsontable(container, {
                data: data,
                colHeaders: ["Матеріал", "Ціна (у грн)", "Короткий опис", "Кількість на складі", "Дата закупки", "Строк зберігання"],
                rowHeaders: false,
                filters: true,
                search: true,
                width: '100%',
                readOnly: true,
                dropdownMenu: ['filter_by_condition', 'filter_by_value', 'filter_action_bar'],

                height: '90%',
                stretchH: 'all',
                licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only

            });
            hot.updateSettings({
                colHeaders: modifiedColHeaders
            })
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>