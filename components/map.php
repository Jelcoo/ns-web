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

    function onEachFeature(feature, layer) {
        // does this feature have a property named popupContent?
        if (feature.properties && feature.properties.disruptionType) {
            layer.bindTooltip(feature.properties.disruptionType);
        }
    }

    const disruptions = <?php echo json_encode($disruptions); ?>;
    disruptions.payload.features.forEach(feature => {
        if (feature.properties.disruptionType != 'STORING') return;

        const disruptionStyle = {
            "color": '#FF0000',
            "weight": 5
        };
        L.geoJSON(feature, {
            style: disruptionStyle,
            onEachFeature: onEachFeature
        }).addTo(map);

        const typeIcon = L.icon({
            iconUrl: 'assets/img/icon/exclamation-red.svg',

            iconAnchor:   [25, 30],
            popupAnchor:  [0, 0]
        });
        
        const featureCoords = feature.geometry.coordinates[0];
        const middleCoords = featureCoords[Math.floor(featureCoords.length / 2)];
        L.marker(middleCoords.reverse(), {icon: typeIcon}).addTo(map);
    });
</script>
