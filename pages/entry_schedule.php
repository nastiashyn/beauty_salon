<?php

session_start();
use function Models\checkRegistered;


require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Графік записів";
?>
<?php require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="session-info">
                <h2>Session Details</h2>
                <p><strong>Date:</strong> <span id="sessionDate"></span></p>
                <p><strong>Client Name:</strong> <span id="clientName"></span></p>
                <p><strong>Master Name:</strong> <span id="masterName"></span></p>
                <p><strong>Session Start:</strong> <span id="sessionStart"></span></p>
                <p><strong>Session End:</strong> <span id="sessionEnd"></span></p>
                <div id="servicesList">
                    <!-- Services will be dynamically added here -->
                </div>
                <p><strong>Total:</strong> $<span id="sessionTotal"></span></p>
            </div>
        </div>
    </div>
    <section id="entry_schedule">

        <div id="schedule" class="card overflow-show">
            <div id="calendar"></div>

        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                customButtons: {
                    ButtonAdd: {
                        text: 'Додати',
                        click: function () {
                            location.href = "add_seans.php";
                        }
                    }
                },
                eventClick: function (info) {
                    OpenModal(info.event.extendedProps)
                },
                businessHours: {
                    startTime: '10:00', // a start time (10am in this example)
                    endTime: '20:00', // an end time (6pm in this example)
                },
                buttonHints: {
                    next: 'Наступна label',
                    prev: 'Попередня label',
                    month: 'Місяць',
                    day: 'День',
                    week: 'Тиждень'
                },
                buttonText: {
                    today: 'Сьогодні',
                    month: 'Місяць',
                    day: 'День',
                    week: 'Тиждень'
                },
                headerToolbar: {
                    left: 'prev,next today ButtonAdd',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'ua',
                eventSources: [
                    {
                        url: '../vendor/ajax/seanses.php',
                        color: 'pink',
                        textColor: 'black'
                    }

                ]
            });
            calendar.render();
        });
        /*---------------------------------------MODAL WINDOW-------------------------------------------- */
        // Get the modal
        var modal = document.getElementById("modal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        const OpenModal = (info) => {
            let content = modal.querySelector(".session-info");
            let servicesList = "";
            info.servicesList.forEach(s => {
                servicesList += "<li>" + s.title + " (" + s.price + "грн) - " + s.masterName + " (" + s.time + "хв)</li>"
            });
            const li = "<h2>" + new Date(info.title).toLocaleDateString('uk-UA', { weekday: "long", day: "numeric", year: "numeric", month: "short" }) + "</h2>" +
                "<p><strong>Клієнт:</strong> <span id=\"clientName\">" + info.clientName + "</span></p>" +
                "<p><strong>Номер тел.:</strong> <span id=\"clientPhone\">" + info.clientPhone + "</span></p>" +
                "<p><strong>Початок та кінець:</strong> <span id=\"sessionStart\">" + new Date(info.sessionStart).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + " - " + new Date(info.sessionEnd).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + "</span></p>" +
                "<div id=\"servicesList\"><strong>Послуги:</strong><ul>" + servicesList +
                "</ul></div>" +
                "<p><strong>Сума:</strong> <span id=\"sessionTotal\">" + info.sessionTotal + "грн</span></p>" +
                "<div class='row j-i-end w-full'>" +
                "<button class='edit' onclick='editSeans(" + info.id + ")'>Змінити</button>" +
                "<button class='delete' onclick='deleteSeans(" + info.id + ")'>Видалити</button>" +
                "</div>";
            content.innerHTML = li;
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        /*---------------------------------------METHODS-------------------------------------------- */
        function editSeans(id) {
            location.href = 'add_seans?id=' + id;
        }
        function deleteSeans(id) {
            location.href = '../vendor/seans/delete.php';
        }
    </script>
    <?php require '../blocks/footer.php'; ?>
</body>

</html>