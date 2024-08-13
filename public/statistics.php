<?php
    chdir(__DIR__."/..");

    require_once "./functions/env.php";

    if (getenv("DEBUG") == "true") {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    require_once "./functions/database.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>NS Trains - Statistics</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="assets/css/style.css" />

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script src="assets/js/utils.js"></script>
        <script src="assets/js/table.js"></script>
    </head>
    <body>
        <?php require './components/navbar.php'; ?>
        <main>
            <section id="statistics">
                <section id="statistic">
                    <?php require './components/charts/frequent-affected-stations.php'; ?>
                </section>
                <section id="statistic">
                    <?php require './components/charts/frequent-causes.php'; ?>
                </section>
                <section id="statistic">
                    <?php require './components/charts/most-affected-days.php'; ?>
                </section>
            </section>
        </main>
    </body>
</html>

<style>
    main {
        padding: 2rem;
    }

    #statistics {
        display: flex;
        gap: 1rem;
    }
    #statistic {
        flex: 25%;
        background-color: #767676;
        padding: 1rem;
        border-radius: 5px;
    }

    span, th, td {
        color: #ffffff;
    }

    .search {
        width: 100%;
        padding: 0.5rem;
        box-sizing: border-box;
        border: none;
        border-radius: 5px;
        margin-bottom: 0.5rem;
    }
    .page-selectors {
        text-align: center;
        margin-bottom: 0.5rem;
    }
    .page-buttons {
        margin-top: 0.2rem;
    }
    .page-button {
        padding: 0.2rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th:first-child, td:first-child {
        text-align: left;
    }
    th:last-child, td:last-child {
        text-align: right;
    }
</style>
