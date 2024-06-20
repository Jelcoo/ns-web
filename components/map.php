<?php
    require_once "./functions/ns_api.php";
    require_once "./functions/ns_database.php";

    $tracksGeo = GetTrainTracksGeo();

    if (
        isset($_GET['start']) &&
        isset($_GET['end']) &&
        isset($_GET['display']) &&
        ($_GET['display'] == "single_date" || $_GET['display'] == "range"))
    {
        $disruptions = GetTrainDisruptionsBetween($_GET['start'], $_GET['end']);
    } else {
        $disruptions = GetActiveTrainDisruptions();
    }
?>

<div id="map"></div>

<script>
    var map = L.map('map').setView([52.13580717626822, 5.746366037663725], 8);

    L.tileLayer('https://{s}.tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=<?php echo getenv("THUNDERFOREST_KEY") ?>', {
        minZoom: 8,
        maxZoom: 12,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const tracks = <?php echo json_encode($tracksGeo); ?>;
    tracks.payload.features.forEach(feature => {
        const trackStyle = {
            "color": "#919191",
            "weight": 2
        };

        L.geoJSON(feature, {
            style: trackStyle
        }).addTo(map);
    });

    const disruptions = <?php echo json_encode($disruptions); ?>;
    disruptions.forEach(disrupt => {
        const disruptionStyle = {
            "color": '#FF0000',
            "weight": 5
        };

        const stationsGeo = JSON.parse(disrupt.stationsGeo);
        stationsGeo.forEach(geo => {
            geo.features.forEach(feature => {
                L.geoJSON(feature, {
                    style: disruptionStyle
                }).addTo(map);

                const typeIcon = L.icon({
                    iconUrl: 'assets/img/icon/exclamation.svg',

                    iconAnchor: [25, 30],
                    popupAnchor: [0, 0]
                });

                const featureCoords = feature.geometry.coordinates;
                if (featureCoords.length < 1) return;

                const middleCoords = featureCoords[Math.floor(featureCoords.length / 2)];
                L.marker(middleCoords.reverse(), {
                    riseOnHover: true,
                    icon: typeIcon
                }).addTo(map).bindTooltip(`${disrupt.cause}\n${disrupt.timeStart}`);
            })
        });
    });
</script>
