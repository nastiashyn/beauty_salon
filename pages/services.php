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
    <section id="services">

        <div id="buttons" class="anticard">
            <?php
            if ($_SESSION['user']['role'] != "client") {
                ?>
                <button onclick="location.href='./add_service.php'" class="">Додати</button>
                <?php
            }
            ?>
        </div>
        <div id="filter_sort_search" class="card">
            <div id="filter">
                Фільтрувати:
                <?php
                if($_SESSION['user']['master_id']==null){
                ?>
                <div class="dropdown">
                    <button onclick="ToggleDropdown('master')" class="dropdown-toggle">За майстром</button>
                    <div id="masterDropdown" class="dropdown-content">
                        <!-- Випадаючий список для мастрів -->
                        <?php
                        $masters = Master::Masters();
                        foreach ($masters as $master) {
                            ?>
                            <button onclick="GetWithFilter('master', '<?= $master[0] ?>')">
                                <?= $master[1] ?>
                            </button>
                            <!-- Додайте інші опції за потреби -->
                            <?php
                        }
                        ?>
                    </div>
                </div>
<?php
              }  
?>
                <div class="dropdown">
                    <button onclick="ToggleDropdown('price')" class="dropdown-toggle">За ціною</button>
                    <div id="priceDropdown" class="dropdown-content">
                        <!-- Випадаючий список для ціни -->
                        <button onclick="GetWithFilter('price', '0-100')">Від 0 до 100 грн</button>
                        <button onclick="GetWithFilter('price', '100-500')">Від 100 до 500 грн</button>
                        <button onclick="GetWithFilter('price', '500-1000')">Від 500 до 1000 грн</button>
                        <!-- Додайте інші опції за потреби -->
                    </div>
                </div>
            </div>

            <div id="sort">
                Сортувати:
                <button onclick="GetWithSort('title')" class="">По назві</button>
                <button onclick="GetWithSort('price')" class="">По ціні</button>
                <!--<button onclick="GetWithSort('rating')" class="">По рейтингу</button>-->
            </div>
            <div id="search">
                <input type="search" onchange="GetWithSearch()" name="search" id="search" placeholder="">
                <button onclick="GetWithSearch()">Шукати</button>
            </div>
        </div>
        <div id="services_list" class="anticard"></div>
    </section>
    <script>
        let data = [];
        let filter = "default";
        let searchWord = "default";
        let sort = "default";
        //------------------------------------DOCUMENT READY------------------------------------
        document.addEventListener("DOMContentLoaded", function (event) {
            LoadData();
        });
        //------------------------------------LOAD DATA------------------------------------
        function LoadData() {
            
            $.getJSON("../../vendor/ajax/services.php?filter=" + filter + "&sort=" + sort + "&searchword=" + searchWord, function (resp) {
                data = resp;
                PrintData();
            });
        }
        //------------------------------------PRINT DATA------------------------------------
        function PrintData() {
            let res = "";
            if(data.length==0) res="<p style=\"text-align:center;color:darkgray;font-size:larger;\">Послуг не знайдено</p>"
            data.forEach(service => {
                res += "<div class=\"card service-item\">" +
                    "<div class=\"card-cell\"><h4>" + service.title + "</h4></div>" +
                    /*"<div class=\"card-cell\"><p class=\"rating\" title=\"Рейтинг: " + service.rating + "\">" + service.rating_icon + "</p></div>" +
                    */"<div class=\"card-cell\"><p>" + service.price + " грн</p></div>" +
                    "<div class=\"card-cell\"><p>" + service.masters + "</p></div>" +
                    "<div class=\"card-cell\"><span>" +
                    "<button onclick=\"ShowService(" + service.id + ")\" title=\"Переглянути детальніше\" class=\"show icon\"><ion-icon name=\"eye\"></ion-icon></button>" +
                    <?php
                    if ($_SESSION['user']['role'] != "client") {
                        ?>"<button onclick=\"DuplicateService(" + service.id + ")\" title=\"Створити копію\" class=\"copy icon\"><ion-icon name=\"copy\"></ion-icon></button>" +
                        "<button onclick=\"EditService(" + service.id + ")\" title=\"Редагувати\" class=\"edit icon\"><ion-icon name=\"create\"></ion-icon></button>" +
                        "<button onclick=\"DeleteService(" + service.id + ")\" title=\"Видалити\" class=\"delete icon\"><ion-icon name=\"trash\"></ion-icon></button>" +
                        <?php
                    } else if ($_SESSION['user']['role'] == "client"){
                        ?>
                        "<button onclick=\"AddSeans(" + service.id + ")\" title=\"Записатись на послугу\" class=\"add icon\"><ion-icon name=\"add-outline\"></ion-icon></button>" +
                        <?php
                    }
                    ?>
                "</span></div>" +
                    "</div>";
            });
            $("#services_list").html(res);
        }
        //------------------------------------ROUTERS------------------------------------
        const ShowService = (id) => location.href = "./show_service.php?id=" + id;
        const DuplicateService = (id) => {
            location.href = "./add_service.php?id=" + id + "&type=copy";
        }
        const EditService = (id) => location.href = "./add_service.php?id=" + id + "&type=edit";
        function DeleteService(id) {
            $.getJSON('../vendor/ajax/delete/service.php?id=' + id, function (resp) {
                alert(resp.message);
                LoadData();

            });
        }
        const AddSeans = (id) => location.href = "./add_seans.php?service_id=" + id;
        //------------------------------------METHODS------------------------------------
        function GetWithFilter(param, value) {
            filter = param + "_" + value;
            LoadData();
            ToggleDropdown(param)
        }
        function GetWithSearch() {
            searchWord = $("input#search").val();
            if (searchWord != "" || data.length == 0) LoadData();
           
        }
        function GetWithSort(param) {
            sort = param;
            LoadData();
        }
        //------------------------------------TOGGLE------------------------------------
        function ToggleDropdown(filter) {
            var dropdown = document.getElementById(filter + 'Dropdown');
            dropdown.classList.toggle('show');
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>