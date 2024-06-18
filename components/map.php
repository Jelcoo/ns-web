<?php
    require "./functions/ns_api.php";

    $tracks = GetTrainTracks();
    $disruptions = GetTrainDisruptions();
?>

<div id="map"></div>

<script>
    var map = L.map('map').setView([52.13580717626822, 5.746366037663725], 8);

    L.tileLayer('https://{s}.tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=<?php echo getenv("THUNDERFOREST_KEY") ?>', {
        minZoom: 8,
        maxZoom: 12,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const tracks = <?php echo json_encode($tracks); ?>;
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
    disruptions.payload.features.forEach(feature => {
        const disruptionStyle = {
            "color": feature.properties.disruptionType == 'STORING' ? '#FF0000' : '#FF9900',
            "weight": 5
        };
        L.geoJSON(feature, {
            style: disruptionStyle
        }).addTo(map);
    });
</script>
