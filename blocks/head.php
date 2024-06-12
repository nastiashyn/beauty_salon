<?php

require_once 'C:\Users\Julie\source\beauty_salon/blocks/models.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/card.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/sections.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/text.css">
    <link rel="stylesheet" href="../css/row_col.css">
    <link rel="stylesheet" href="../css/shedule.css">
    <link rel="stylesheet" href="../css/auth.css">

    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php
    if ($name_page == "Графік записів") {
        ?>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

        <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>
        <?= $name_page ?>
    </title>
    <style>
        .alert {
            opacity: 1;
            transition: opacity 0.6s;
            /* 600ms to fade out */
        }
    </style>
</head>