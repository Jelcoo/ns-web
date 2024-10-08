<?php
    require_once "./functions/ns_api.php";
    require_once "./functions/ns_database.php";

    $tracksGeo = GetTrainTracksGeo();
?>

<script>
    const thunderforestKey = "<?php echo getenv("THUNDERFOREST_KEY") ?>";
    const tracks = <?php echo json_encode($tracksGeo); ?>;
    const map = makeMap(thunderforestKey, 8, 16, tracks);

    const tainsLayer = L.layerGroup().addTo(map);
    const trainMarkers = [];

    const focusedTrainNr = getUrlQuery('trein');
    const defaultfocusedTrainZoom = 14;
    let focusedTrainZoom = defaultfocusedTrainZoom;
    map.on('zoomend', function() {
        focusedTrainZoom = map.getZoom();
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
                    .bindTooltip(trainToTooltip(train))
                    .on('click', function(e) {
                        if (focusedTrainNr === train.treinNummer.toString()) {
                            removeUrlQuery(['trein']);
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
                    existingMarker.marker.bindTooltip(trainToTooltip(train));
                }

                if (focusedTrainNr === train.treinNummer.toString()) {
                    existingMarker.marker.setIcon(train.type === 'SPR' ? sprinterFocusIcon : train.type === 'IC' ? icFocusIcon : arrivaFocusIcon);
                }
            }
        });

        if (focusedTrainNr) {
            const trainMarker = trainMarkers.find(marker => marker.treinNummer === focusedTrainNr);
            if (trainMarker) {
                const marketLatLng = trainMarker.marker.getLatLng();
                map.setView(marketLatLng, focusedTrainZoom);
            }
        }
    });
</script>
