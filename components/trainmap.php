<?php
    require_once "./functions/ns_api.php";
    require_once "./functions/ns_database.php";

    $tracksGeo = GetTrainTracksGeo();
?>

<div id="map"></div>

<script>
    var map = L.map('map').setView([52.13580717626822, 5.746366037663725], 8);

    L.tileLayer('https://{s}.tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=<?php echo getenv("THUNDERFOREST_KEY") ?>', {
        minZoom: 8,
        maxZoom: 16,
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

    const trainIcon = L.icon({
        iconUrl: 'assets/img/icon/exclamation.svg',
    
        iconSize: [25, 30],
        popupAnchor: [0, 0]
    });

    const tainsLayer = L.layerGroup().addTo(map);

    const socket = io("wss://nsws.jelco.xyz", {
        transports: ['websocket']
    });
    socket.on('vehicles', (vehicles) => {
        tainsLayer.clearLayers();

        vehicles.payload.treinen.forEach(train => {
            L.marker([train.lat, train.lng], {
                riseOnHover: true,
                icon: trainIcon
            }).addTo(tainsLayer).bindTooltip(`Type: ${train.type}<br>Snelheid: ${train.snelheid} km/h`);
        });
    });
</script>
