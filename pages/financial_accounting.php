<?php

session_start();

use function Models\checkRegistered;

require_once '../models/data.php'; 
use function Models\checkNotRegistered;
checkRegistered();
$name_page = "Фінансовий облік";
require '../blocks/head.php'; ?>

<body>
    <?php require "../blocks/main_and_header.php"; ?>
    <?php require "../blocks/nav.php"; ?>
    <section id="financial_accounting">
        <div id="form" class="anticard">
            <input type="date" id="start_date">
            <input type="date" id="end_date">
            <button type="button" onclick="ChoosePeriod()">Обрати проміжок</button>
        </div>
        <div id="buttons" class="anticard">
            <!--<button onclick="location.href='./documents.php'">Переглянути документи</button>-->
            <button onclick="location.href='./add_finance_data.php'">Додати витрати/дохід</button>
        </div>
        <!--<div id="card1" class="card card-info">
            <h5>Дохід <small>за місяць</small></h5>
            <div class="row j-c-b">
                <ul>
                    <li title="За поточний місяць" id="LabelForIncomeByCurrentMonth">За поточний місяць: грн
                    </li>
                    <li title="За минулий місяць" id="LabelForIncomeByPreviousMonth">За минулий місяць: грн
                    </li>
                </ul>
                <h4 title="Пор" id="LabelForIncomeInProcents"></h4>
            </div>
        </div>
        <div id="card2" class="card card-info">
            <h5>Витрати <small>за місяць</small></h5>
            <div class="row j-c-b">
                <ul>
                    <li title="За поточний місяць" id="LabelForExpensesByCurrentMonth">За поточний місяць: грн
                    </li>
                    <li title="За минулий місяць" id="LabelForExpensesByPreviousMonth">За минулий місяць: грн
                    </li>
                </ul>
                <h4 title="Пор" id="LabelForExpensesInProcents"></h4>
            </div>
        </div>
        <div id="card3" class="card card-info">
            <h5>Прибуток <small>за місяць</small></h5>
            <div class="row j-c-b">
                <ul>
                    <li title="За поточний місяць" id="LabelForProfitByCurrentMonth">За поточний місяць: грн
                    </li>
                    <li title="За минулий місяць" id="LabelForProfitByPreviousMonth">За минулий місяць: грн
                    </li>
                </ul>
                <h4 title="Пор" id="LabelForProfitInProcents">

                </h4>
            </div>
        </div>
-->
        <div id="chart" class="card"></div>
        <div id="report" class="card">
            <div id="report_table" class="anticard"></div>
        </div>

        <div id="top_clients" class="card card-top">
            <h5>Топ-клієнти:</h5>
            <table>
                <tbody id="ListOfTopClients"></tbody>
            </table>
        </div>
        <div id="top_services" class="card card-top">
            <h5>Топ-послуги:</h5>
            <table>
                <tbody id="ListOfTopServices"></tbody>
            </table>
        </div>
        <div id="top_employee" class="card card-top">
            <h5>Топ-майстри:</h5>
            <table>
                <tbody id="ListOfTopMasters"></tbody>
            </table>
        </div>
    </section>
    <?php require '../blocks/footer.php'; ?>
    <script>
        /*------------------------------------VARIABLES------------------------------------ */
        //data like examples
        let min_date = null;
        let max_date = null;

        let groupBy = null;
        let data = [
            { date_1: "01-01-2023", date_2: "31-01-2023", materials: 30, salary: 50, seanses: 400, rent: 120, utilities: 40, others_income: 40, others_expences: 40, _income: 0, _expenses: 0, _profit: 0 },
            { date_1: "01-02-2023", date_2: "29-01-2023", materials: 40, salary: 50, seanses: 540, rent: 120, utilities: 40, others_income: 40, others_expences: 40, _income: 0, _expenses: 0, _profit: 0 },
            { date_1: "01-03-2023", date_2: "31-01-2023", materials: 60, salary: 50, seanses: 660, rent: 120, utilities: 40, others_income: 40, others_expences: 40, _income: 0, _expenses: 0, _profit: 0 },
            { date_1: "01-04-2023", date_2: "30-01-2023", materials: 30, salary: 40, seanses: 350, rent: 120, utilities: 40, others_income: 40, others_expences: 40, _income: 0, _expenses: 0, _profit: 0 },
            { date_1: "01-05-2023", date_2: "31-01-2023", materials: 40, salary: 50, seanses: 440, rent: 120, utilities: 40, others_income: 40, others_expences: 40, _income: 0, _expenses: 0, _profit: 0 }
        ];


        function CalcIncomeExpensesAndProfit(data) {
            data.forEach(group => {
                group._income = group.seanses + group.others_income;
                group._expenses = group.materials + group.salary + group.rent + group.utilities + group.others_expences;
                group._profit = group._income - group._expenses;
            });
            return data;

        }

        let sums_of_data = CalcSumsByGroups(data);

        function CalcSumsByGroups(data) {
            let res = {
                materials: 0,
                salary: 0,
                seanses: 0,
                rent: 0,
                utilities: 0,
                others_income: 0,
                others_expences: 0,
                _income: 0,
                _expenses: 0,
                _profit: 0,
            };
            for (let i = 0; i < data.length; i++) {
                const group = data[i];
                res.materials += group.materials;
                res.salary += group.salary;
                res.seanses += group.seanses;
                res.rent += group.rent;
                res.utilities += group.utilities;
                res.others_income += group.others_income;
                res.others_expences += group.others_expences;
                res._income += group._income;
                res._expenses += group._expenses;
                res._profit += group._profit;
            }
            return res;
        }
        let top_clients = null;
        let top_services = null;
        let top_masters = null;



        //------------------------------------DOCUMENT READY------------------------------------
        document.addEventListener("DOMContentLoaded", function (event) {
            //todo get min and max dates(ajax)
            LoadMinAndMaxDates()
        });

        //------------------------------------CHOOSE PERIOD------------------------------------
        function ChoosePeriod() {
            //add min and max date
            //check min < max + 
            let date1 = $("#start_date").val();
            let date2 = $("#end_date").val();
            if ((new Date(date1)) > (new Date(date2))) alert("Оберіть період правильно");
            else {
                LoadData(date1, date2)
                data = CalcIncomeExpensesAndProfit(data);
                sums_of_data = CalcSumsByGroups(data);

                DrawTable();
                UpdateChart();
                DrawCards();
            }
        }

        //------------------------------------LOAD DATA------------------------------------
        function LoadData(date1, date2) {
            $.getJSON("../../vendor/ajax/financial_accounting_by_period.php?date1=" + date1 + "&date2=" + date2, function (resp) {

                groupBy = resp.groupBy;
                data = resp.data;

                top_clients = resp.tops.top_clients;
                top_services = resp.tops.top_services;
                top_masters = resp.tops.top_masters;
            });
        }
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
        function LoadMinAndMaxDates() {
            $.getJSON("../../vendor/ajax/min_and_max_date.php", function (dates) {
                min_date = new Date(dates.min_date);
                max_date = new Date(dates.max_date);

                $("#start_date").val(formatDate(min_date));
                $("#end_date").val(formatDate(max_date));
                $("#end_date").attr({ "min": formatDate(min_date), "max": formatDate(max_date) });
                $("#start_date").attr({ "max": formatDate(max_date), "min": formatDate(min_date) });

                LoadData(formatDate(min_date), formatDate(max_date));
                data = CalcIncomeExpensesAndProfit(data);
                sums_of_data = CalcSumsByGroups(data);

                DrawTable();
                DrawChart();
                DrawCards();

            });
        }

        //------------------------------------TABLE------------------------------------
        function DrawTable() {

            const container = document.querySelector('#report_table');
            const hot = new Handsontable(container, {
                data: [
                    ['Звіт за весь час(у грн)', 'Дохід', 'Витрати', 'Прибуток'],
                    ['Послуги', sums_of_data.seanses + ' грн', '-', '-'],
                    ['Матеріали', '-', sums_of_data.materials + ' грн', '-'],
                    ['Зар.плата', '-', sums_of_data.salary + ' грн', '-'],
                    ['Оренда', '-', sums_of_data.rent + ' грн', '-'],
                    ['Ком.послуги', '-', sums_of_data.utilities + ' грн', '-'],
                    ['Інше', sums_of_data.others_income + ' грн', sums_of_data.others_expences + ' грн', '-'],
                    ['Всього', sums_of_data._income + ' грн', sums_of_data._expenses + ' грн', sums_of_data._profit + ' грн']
                ],
                renderAllRows: true,
                rowHeaders: false,
                colHeaders: false,
                readOnly: true,
                width: 500,
                height: 250,
                stretchH: 'all',
                licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only
            });
        }
        //------------------------------------CHART------------------------------------
        let chart;
        function DrawChart() {
            let groups = [];
            //написати заголовки як місяці(або тижні(скорочено), роки або проміжки місяців(наприклад, "лют-квіт"))
            let incomeByGroups = [];
            let expensesByGroups = [];
            let profitByGroups = [];
            for (let i = 0; i < data.length; i++) {
                let group = data[i];
                groups.push(group.date_1 + "-" + group.date_2);
                incomeByGroups.push(group._income);
                expensesByGroups.push(group._expenses);
                profitByGroups.push(group._profit);
            }

            var options = {
                series: [{
                    name: "Дохід",
                    data: incomeByGroups
                }, {
                    name: "Витрати",
                    data: expensesByGroups
                }, {
                    name: "Прибуток",
                    data: profitByGroups
                }],
                colors: ['#aa74dd', '#dd9274', '#74dd82'],
                chart: {
                    height: 220,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: groups,
                }
            };

            chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }
        function UpdateChart() {
            let groups = [];
            //написати заголовки як місяці(або тижні(скорочено), роки або проміжки місяців(наприклад, "лют-квіт"))
            let incomeByGroups = [];
            let expensesByGroups = [];
            let profitByGroups = [];
            for (let i = 0; i < data.length; i++) {
                let group = data[i];
                groups.push(group.date_1 + "-" + group.date_2);
                incomeByGroups.push(group._income);
                expensesByGroups.push(group._expenses);
                profitByGroups.push(group._profit);
            }
            chart.updateSeries([{
                name: "Дохід",
                data: incomeByGroups
            }, {
                name: "Витрати",
                data: expensesByGroups
            }, {
                name: "Прибуток",
                data: profitByGroups
            }], true)
        }
        //------------------------------------FILL CARDS------------------------------------
        /*const CalcProcents = (val1, val2) => {
            if (val2 === 0) {
                return 0; // Або яке-небудь інше значення за вашим вибором
            }
            return Math.round((((val1 * 100) / val2) - 100), 0);
        };

        const PrintProcents = (val1, val2) => {
            if (val2 === 0) {
                return " - %"; // Або інше повідомлення про помилку
            }
            return CalcProcents(val1, val2) < 0 ? CalcProcents(val1, val2) + "%" : "+" + CalcProcents(val1, val2) + "%";
        };

        async function GetCurrentMonth() {
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var firstDay = new Date(y, m, 1);
            var lastDay = new Date(y, m + 1, 0);

            return new Promise((resolve, reject) => {
                $.getJSON("../../vendor/ajax/financial_accounting_by_period.php?date1=" + DateFormat(firstDay) + "&date2=" + DateFormat(lastDay), function (resp) {
                    let data_ = resp.data;
                    data_.forEach(group => {
                        group._income = group.seanses + group.others_income;
                        group._expenses = group.materials + group.salary + group.rent + group.utilities + group.others_expences;
                        group._profit = group._income - group._expenses;
                    });
                    resolve(CalcSumsByGroups(data_));
                });
            });
        }

        async function GetPreviousMonth() {
            var date = new Date();
            var firstDay = new Date(date.getFullYear(), date.getMonth() - 1, 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth(), 0);

            return new Promise((resolve, reject) => {
                $.getJSON("../../vendor/ajax/financial_accounting_by_period.php?date1=" + DateFormat(firstDay) + "&date2=" + DateFormat(lastDay), function (resp) {
                    let data_ = resp.data;
                    data_.forEach(group => {
                        group._income = group.seanses + group.others_income;
                        group._expenses = group.materials + group.salary + group.rent + group.utilities + group.others_expences;
                        group._profit = group._income - group._expenses;
                    });
                    resolve(CalcSumsByGroups(data_));
                });
            });
        }
        function DateFormat(date) {
            var year = date.toLocaleString("default", { year: "numeric" });
            var month = date.toLocaleString("default", { month: "2-digit" });
            var day = date.toLocaleString("default", { day: "2-digit" });

            return year + "-" + month + "-" + day;
        }
        */
        async function DrawCards() {
            /*let group_by_current_month = await GetCurrentMonth();
            let group_by_previous_month = await GetPreviousMonth();

            console.log("group_by_current_month", group_by_current_month);
            console.log("group_by_previous_month", group_by_previous_month);

            document.getElementById("LabelForIncomeByCurrentMonth").innerText = "За поточний місяць: " + group_by_current_month._income + " грн";
            document.getElementById("LabelForIncomeByPreviousMonth").innerText = "За минулий місяць: " + group_by_previous_month._income + " грн";
            document.getElementById("LabelForIncomeInProcents").innerText = PrintProcents(group_by_current_month._income, group_by_previous_month._income);

            document.getElementById("LabelForExpensesByCurrentMonth").innerText = "За поточний місяць: " + group_by_current_month._expenses + " грн";
            document.getElementById("LabelForExpensesByPreviousMonth").innerText = "За минулий місяць: " + group_by_previous_month._expenses + " грн";
            document.getElementById("LabelForExpensesInProcents").innerText = PrintProcents(group_by_current_month._expenses, group_by_previous_month._expenses);

            document.getElementById("LabelForProfitByCurrentMonth").innerText = "За поточний місяць: " + group_by_current_month._profit + " грн";
            document.getElementById("LabelForProfitByPreviousMonth").innerText = "За минулий місяць: " + group_by_previous_month._profit + " грн";
            document.getElementById("LabelForProfitInProcents").innerText = PrintProcents(group_by_current_month._profit, group_by_previous_month._profit);
*/
            document.getElementById("ListOfTopClients").innerHTML = CreateHtmlForTopList(top_clients);
            document.getElementById("ListOfTopServices").innerHTML = CreateHtmlForTopList(top_services);
            document.getElementById("ListOfTopMasters").innerHTML = CreateHtmlForTopList(top_masters);
        }

        function CreateHtmlForTopList(data) {
            let html = "";
            data.forEach(person => {
                html += "<tr><td>" + person.id + ".</td><td>" + person.name + "</td><td title=\"Кількість сеансів\">" + person.seanses + "</td><td title=\"Прибуток\">" + person.profit + " грн</td></tr>";
            });
            return html;
        }
    </script>
</body>

</html>