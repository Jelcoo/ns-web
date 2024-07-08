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

<script>
    const thunderforestKey = "<?php echo getenv("THUNDERFOREST_KEY") ?>";
    const tracks = <?php echo json_encode($tracksGeo); ?>;
    const map = makeMap(thunderforestKey, 8, 12, tracks);

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
                }).addTo(map).bindTooltip(`${disrupt.cause}<br>${disrupt.timeStart}`);
            })
        });
    });
</script>
