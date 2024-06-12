<?php

session_start();
use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Майстри";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="masters">
        <div class="card overflow-show" id="gallery">
            <div id="filter_sort_search">
                <button onclick="location.href='add_employer.php'">Додати майстра</button>
                <div class="" id="search">
                    <input type="search" name="search" id="search_input" placeholder="">
                    <button onclick="GetWithSearch()">Шукати</button>
                </div>
            </div>
            <div id="gallery_"></div>
        </div>

    </section>
    <script>
        let data = [];
        let searchWord = "default";
        //------------------------------------DOCUMENT READY------------------------------------
        document.addEventListener("DOMContentLoaded", function (event) {
            LoadData();
        });
        //------------------------------------LOAD DATA------------------------------------
        function LoadData() {
            $.getJSON("../../vendor/ajax/masters.php?searchword=" + searchWord, function (resp) {
                data = resp;
                console.log(resp)
                PrintData();
            });
        }
        //------------------------------------PRINT DATA------------------------------------
        function PrintData() {
            let res = "";
            data.forEach(master => {
                res += "<div class=\"card master-card\">" +
                    "<h5>" + master.full_name + "</h5>" +
                    "<p><i style=\"font-weight:lighter\">" + master.status + "</i></p>" +
                    "<p>" + master.phone + "<ion-icon class=\"copy-icon\" onclick=\"CopyPhone('" + master.phone + "')\" name=\"copy-outline\"></ion-icon></p>" +
                    "<p>Зар.плата: <em>" + master.salary + " грн</em></p>" +
                    "<p>Прибуток за сеанси: <em>" + master.profit_from_seanses + " грн</em></p>" +
                    "<p>Послуги: <small style=\"font-weight:lighter\">" + master.services + "</small></p>" +
                    "<div class=\"events\">" +
                    "<button onclick=\"ShowService(" + master.id + ")\" title=\"Переглянути\" class=\"show icon\"><ion-icon name=\"eye\"></ion-icon></button>" +
                    "<button onclick=\"EditService(" + master.id + ")\" title=\"Редагувати\" class=\"edit icon\"><ion-icon name=\"create\"></ion-icon></button>" +
                    "<button onclick=\"DeleteService(" + master.id + ")\" title=\"Видалити\" class=\"delete icon\"><ion-icon name=\"trash\"></ion-icon></button></div></div>";
            });
            $("#gallery_").html(res);
        }
        //------------------------------------ROUTERS------------------------------------
        const ShowService = (id) => location.href = "./show_master.php?id=" + id;
        const EditService = (id) => location.href = "./add_employer.php?id=" + id + "&type=edit";
        function DeleteService(id) {
            $.getJSON('../vendor/ajax/delete/master.php?id=' + id, function (resp) {

                Alert('danger', resp.message)
                LoadData();

            });
        }
        function CopyPhone(phone) {
            // Copy the text inside the text field
            navigator.clipboard.writeText(phone);
            Alert('success', "Номер телефону " + phone + " скопійований!")
        }
        //------------------------------------METHODS------------------------------------

        function GetWithSearch() {
            searchWord = $("#search_input").val();
            if (searchWord != "" || data.length == 0) LoadData();
        }

    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>