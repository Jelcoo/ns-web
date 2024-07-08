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
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/sprinter.svg'
    });
    const sprinterFocusIcon = L.icon({
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/sprinter_focused.svg'
    });
    const icIcon = L.icon({
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/intercity.svg'
    });
    const icFocusIcon = L.icon({
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/intercity_focused.svg'
    });
    const arrivaIcon = L.icon({
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/arriva.svg'
    });
    const arrivaIconIcon = L.icon({
        iconSize: [25, 30],
        popupAnchor: [0, 0],
        iconUrl: 'assets/img/icon/arriva_focused.svg'
    });

    const tainsLayer = L.layerGroup().addTo(map);
    const trainMarkers = [];

    const focussedTrain = getUrlQuery('trein');
    const defaultFocussedTrainZoom = 14;
    let focussedTrainZoom = defaultFocussedTrainZoom;
    map.on('zoomend', function() {
        focussedTrainZoom = map.getZoom();
    });

    const socket = io("wss://nsws.jelco.xyz", {
        transports: ['websocket']
    });
    socket.on('vehicles', (vehicles) => {
        vehicles.payload.treinen.forEach(train => {
            if (train.type != 'SPR' && train.type != 'IC' && train.type != 'ARR') return;

            const existingMarker = trainMarkers.find(marker => marker.treinNummer === train.treinNummer.toString());

            if (!existingMarker) {
                const marker = L.marker([train.lat, train.lng], {
                    riseOnHover: true,
                    icon: train.type === 'SPR' ? sprinterIcon : train.type === 'IC' ? icIcon : arrivaIcon
                });

                marker.addTo(tainsLayer)
                    .bindTooltip(`Type: ${train.type}<br>Snelheid: ${train.snelheid} km/h`)
                    .on('click', function(e) {
                        if (focussedTrain === train.treinNummer.toString()) {
                            removeUrlQuery(['trein']);
                            focussedTrainZoom = defaultFocussedTrainZoom;
                        } else {
                            setUrlQuery(['trein', train.treinNummer]);
                        }
                    });

                trainMarkers.push({
                    treinNummer: train.treinNummer.toString(),
                    speed: train.snelheid,
                    direction: train.richting,
                    marker: marker
                });
            } else {
                const existingLatLng = existingMarker.marker.getLatLng();
                if (existingLatLng.lat !== train.lat || existingLatLng.lng !== train.lng) {
                    existingMarker.marker.setLatLng([train.lat, train.lng]);
                    existingMarker.marker.bindTooltip(`Type: ${train.type}<br>Snelheid: ${train.snelheid} km/h`);
                }

                if (focussedTrain === train.treinNummer.toString()) {
                    existingMarker.marker.setIcon(train.type === 'SPR' ? sprinterFocusIcon : train.type === 'IC' ? icFocusIcon : arrivaFocusIcon);
                }
            }
        });

        if (focussedTrain) {
            const trainMarker = trainMarkers.find(marker => marker.treinNummer === focussedTrain);
            if (trainMarker) {
                const marketLatLng = trainMarker.marker.getLatLng();
                map.setView(marketLatLng, focussedTrainZoom);
            }
        }
    });
</script>
