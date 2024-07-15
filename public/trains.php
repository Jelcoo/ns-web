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
        <title>NS Trains</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="assets/css/style.css" />

        <!-- Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

        <!-- Socket.io -->
        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>

        <script src="assets/js/utils.js"></script>
        <script src="assets/js/map.js"></script>
        <script src="assets/js/trainmap.js"></script>
    </head>
    <body>
        <?php require './components/navbar.php'; ?>
        <main>
            <section id="trains">
                <section id="trains_details">
                    <?php require './components/trainmap_details.php'; ?>
                </section>
                <section id="trains_map">
                    <div id="map"></div>
                     <?php require './components/trainmap.php'; ?>
                </section>
            </section>
            <script>
                if (focusedTrainNr) {
                    const trainsDetails = document.getElementById('trains_details');
                    const trainsMap = document.getElementById('trains_map');

                    trainsDetails.style.flex = '20%';
                    trainsDetails.style.display = 'block';
                    trainsMap.style.flex = '80%';
                    map.invalidateSize();
                }
            </script>
        </main>
    </body>
</html>
