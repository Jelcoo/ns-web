<?php
    require_once "./functions/ns_api.php";

    $trainNr = $_GET['trein'];
    if (isset($_GET['trein'])) {
        $trainJourney = GetTrainByRitnr($trainNr);
    }
?>

<div id="details">
    <button id="close-details">Close</button>
    <div class="detail">
        <span class="detail_header">Ritnummer:&nbsp;</span>
        <span id="detail_ritnr"></span>
    </div>
    <div class="detail">
        <span class="detail_header">Snelheid:&nbsp;</span>
        <span id="detail_speed"></span>
    </div>
    <div class="detail">
        <span class="detail_header">Type:&nbsp;</span>
        <span id="detail_type"></span>
    </div>
    <div class="detail">
        <span class="detail_header">Materieel:&nbsp;</span>
        <span id="detail_materieel"></span>
    </div>
</div>

<script>
    const trainJourney = <?php echo isset($trainJourney) ? json_encode($trainJourney) : 'null'; ?>;
    let focusedTrain;
    socket.on('vehicles', (vehicles) => {
        vehicles.payload.treinen.forEach(train => {
            if (getUrlQuery('trein') === train.treinNummer.toString()) {
                focusedTrain = train;
            }
        });

        if (focusedTrain) {
            document.getElementById('detail_ritnr').innerHTML = focusedTrain.treinNummer;
            document.getElementById('detail_speed').innerHTML = `${Math.round(focusedTrain.snelheid, 1)} km/h`;
            document.getElementById('detail_type').innerHTML = focusedTrain.type;
            if (focusedTrain.materieel) {
                document.getElementById('detail_materieel').innerHTML = focusedTrain.materieel.join(', ');
            } else {
                document.getElementById('detail_materieel').innerHTML = 'Onbekend';
            }
        }
    });

    const closeButton = document.getElementById('close-details');
    closeButton.addEventListener('click', () => {
        removeUrlQuery(['trein']);
    });
</script>
