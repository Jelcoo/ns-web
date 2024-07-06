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

    const sprinterIcon = L.icon({
        iconUrl: 'assets/img/icon/sprinter.svg',
    
        iconSize: [25, 30],
        popupAnchor: [0, 0]
    });
    const icIcon = L.icon({
        iconUrl: 'assets/img/icon/intercity.svg',
    
        iconSize: [25, 30],
        popupAnchor: [0, 0]
    });

    const tainsLayer = L.layerGroup().addTo(map);
    const trainMarkers = [];

    const focussedTrain = getUrlQuery('trein');

    const socket = io("wss://nsws.jelco.xyz", {
        transports: ['websocket']
    });
    socket.on('vehicles', (vehicles) => {
        vehicles.payload.treinen.forEach(train => {
            if (train.type != 'SPR' && train.type != 'IC') return;

            const existingMarker = trainMarkers.find(marker => marker.treinNummer === train.treinNummer);

            if (!existingMarker) {
                const marker = L.marker([train.lat, train.lng], {
                    riseOnHover: true,
                    icon: train.type === 'SPR' ? sprinterIcon : icIcon
                });

                marker.addTo(tainsLayer)
                    .bindTooltip(`Type: ${train.type}<br>Snelheid: ${train.snelheid} km/h`)
                    .on('click', function(e) {
                        if (focussedTrain) {
                            removeUrlQuery(['trein']);
                        } else {
                            setUrlQuery(['trein', train.treinNummer]);
                        }
                    });

                trainMarkers.push({ treinNummer: train.treinNummer, marker: marker });
            } else {
                if (existingMarker.marker.getLatLng().lat !== train.lat || existingMarker.marker.getLatLng().lng !== train.lng) {
                    existingMarker.marker.setLatLng([train.lat, train.lng]);
                    existingMarker.marker.bindTooltip(`Type: ${train.type}<br>Snelheid: ${train.snelheid} km/h`);
                }
            }
        });

        if (focussedTrain) {
            const trainMarker = trainMarkers.find(marker => marker.treinNummer === parseInt(focussedTrain));
            if (trainMarker) {
                map.setView(trainMarker.marker.getLatLng(), 13);
            }
        }
    });
</script>
