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
    </head>
    <body>
        <?php require './components/navbar.php'; ?>
        <main>
            <section id="statistics">
                <section id="statistic">
                    <?php require './components/charts/frequent-affected-stations.php'; ?>
                </section>
                <section id="statistic">
                </section>
            </section>
        </main>
    </body>
</html>

<style>
    main {
        padding: 2rem;
    }
</style>
