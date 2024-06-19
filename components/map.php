<?php
    require "./functions/ns_api.php";

    $tracksGeo = GetTrainTracksGeo();
    $disruptions = GetTrainDisruptions();
    $disruptionsGeo = GetTrainDisruptionsGeo();
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
    const disruptionsGeo = <?php echo json_encode($disruptionsGeo); ?>;
    disruptionsGeo.payload.features.forEach(disruptGeo => {
        const disrupt = disruptions.find(disrupt => disrupt.id == disruptGeo.id);

        const disruptionStyle = {
            "color": disrupt.type == 'DISRUPTION' ? '#FF0000' : '#FF9900',
            "weight": 5
        };
        L.geoJSON(disruptGeo, {
            style: disruptionStyle
        }).addTo(map);

        const typeIcon = L.icon({
            iconUrl: disrupt.type == 'DISRUPTION'? 'assets/img/icon/exclamation.svg' : 'assets/img/icon/person-digging.svg',

            iconAnchor: [25, 30],
            popupAnchor: [0, 0]
        });

        const featureCoords = disruptGeo.geometry.coordinates[0];
        const middleCoords = featureCoords[Math.floor(featureCoords.length / 2)];
        L.marker(middleCoords.reverse(), {
            riseOnHover: true,
            icon: typeIcon
        }).addTo(map).bindTooltip("Hi");
    });
</script>
