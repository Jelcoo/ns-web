<?php
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
        <title>NS Trains</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="assets/css/style.css" />

        <script src="assets/js/utils.js"></script>

        <!-- Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    </head>
    <body>
        <?php require './components/navbar.php'; ?>
        <main>
            <?php require './components/dateselector.php'; ?>
            <section id="disruptions">
                 <section id="disruptions_list">
 
                 </section>
                 <section id="disruptions_map">
                     <?php require './components/map.php'; ?>
                </section>
            </section>
        </main>
    </body>
</html>
