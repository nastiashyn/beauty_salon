<?php

session_start();


use function Models\checkRegistered;

require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Додати сеанс";
$id = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section>
        <form action="../vendor/seans/add.php" method="post" class="card" id="formAddSeans">
            <div class="form-control">
                <label for="client_id">Клієнт:</label>

                <select name="client_id" id="client_id" <?= $_SESSION["user"]["client_id"] != null ? "disabled" : "" ?>>
                    <?php
                    $clients = Query::Clients();
                    foreach ($clients as $client) {
                        $selected = "";
                        if ($_SESSION["user"]["client_id"] == $client[0])
                            $selected = "selected";
                        ?>
                        <option value="<?= $client[0] ?>" <?= $selected ?>>
                            <?= $client[1] . " (" . $client[3] . ")" ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-control">
                <label for="date">Дата та час:</label>
                <input type="text" name="date" id="date">
            </div>
            <div class="form-control">
                <label for="service_ids">Послуги:</label>
                <select onchange="FillSelectMasters(this.value)" name="service_ids[]" id="service_ids" class="multiple"
                    multiple>
                    <option value='0'>Обрати ...</option>
                    <?php
                    $services = Query::Services();
                    foreach ($services as $service) {
                        $selected = "";
                        if (isset($_GET["service_id"])) {
                            if ($_GET["service_id"] == $service[0])
                                $selected = "selected";
                        }
                        ?>
                        <option value="<?= $service[0] ?>" <?= $selected ?>>
                            <?= $service[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-control">
                <label for="master_id">Майстри:</label>
                <select onchange="FillSelectServices(this.value)" name="master_id" id="master_id" class="multiple"
                    multiple <?= !is_null($_SESSION['user']['master_id']) ? "disabled" : "" ?>>
                    <option value='0'>Обрати ...</option>
                    <?php
                    $masters = Query::Masters();
                    foreach ($masters as $master) {
                        $selected = "";
                        if ($_SESSION['user']['master_id'] == $master[0])
                            $selected = "selected";

                        ?>
                        <option value="<?= $master[0] ?>" <?= $selected ?>>
                            <?= $master[1] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="submit" id="submit_button">Додати</button>
            <button type="button" class="cancel" onclick="location.href='./entry_schedule.php'">Скасувати</button>
        </form>
    </section>
    <script>
        let service_id = <?= isset($_GET["service_id"]) ? $_GET["service_id"] : "0" ?>;
        //alert(service_id);
        let master_id = <?= isset($_SESSION['user']['master_id']) ? $_SESSION['user']['master_id'] : "0" ?>;
        //alert(master_id);
        let data = [];
        function isDateBetween(dateToCheck, startDate, endDate) {
            // Перетворюємо рядки з датами у об'єкти Date
            var date = new Date(dateToCheck);
            var start = new Date(startDate);
            var end = new Date(endDate);

            // Перевіряємо, чи дата перебуває між початковою та кінцевою датами
            return date >= start && date <= end;
        }
        document.addEventListener("DOMContentLoaded", function (event) {
            if (service_id == 0) FillSelectServices(master_id);
            else FillSelectMasters(service_id);
            flatpickr("#date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minTime: "10:00",
                maxTime: "20:00",
                time_24hr: true,
                onChange: function (selectedDates, dateStr, instance) {

                    let a = false;
                    data.forEach(date => {
                        if (isDateBetween(dateStr, date.start, date.end)) {
                            a = true;
                        }
                    });
                    if (a) {
                        $(".numInput.flatpickr-hour").css("color", "indianred");
                        $(".numInput.flatpickr-minute").css("color", "indianred");
                        $(".flatpickr-time-separator").css("color", "indianred");
                        $("#date").css("color", "indianred");
                        $("#submit_button").prop("disabled", true);
                    }
                    else {
                        $(".numInput.flatpickr-hour").css("color", "black");
                        $(".numInput.flatpickr-minute").css("color", "black");
                        $(".flatpickr-time-separator").css("color", "black");
                        $("#date").css("color", "black");
                        $("#submit_button").prop("disabled", false);
                    }
                },
            });
            $.getJSON("../../vendor/ajax/seanses_dates.php", function (resp) {
                data = resp;
            })

        });
        function FillSelectMasters(value) {
            //якщо майстер один
            if (master_id == 0) {
                $.getJSON("../../vendor/ajax/masters_by_service.php?id=" + value, function (resp) {
                    let li = "<option value='0'>Обрати ...</option>";
                    resp.forEach(master => {
                        li += "<option value='" + master.id + "'>" + master.name + "</option>"
                    });
                    document.getElementById("master_id").innerHTML = li;
                });
            }
        }
        function FillSelectServices(value) {
            if (service_id == 0) {
                $.getJSON("../../vendor/ajax/services_by_master.php?id=" + value, function (resp) {
                    let li = "<option value='0'>Обрати ...</option>";
                    resp.forEach(service => {
                        console.log(4)
                        if (service.status == "") li += "<option value='" + service.id + "'>" + service.name + "(" + service.description + ")</option>";
                        else li += "<option value='" + service.id + "' style=\"color:orangered;\">" + service.name + " !" + service.status + "! (" + service.description + ")</option>";
                    });
                    document.getElementById("service_ids").innerHTML = li;
                });
            }
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>