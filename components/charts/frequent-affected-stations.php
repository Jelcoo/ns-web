<?php
    require_once "./functions/ns_database.php";

    $affectedStations = GetStatAffectedStations();
?>

<input type="text" class="search" id="stationSearch" placeholder="Search" />
<div class="page-selectors">
    <span class="page-display" id="station-page-display"></span>
    <div class="page-buttons">
        <button class="page-button" id="station-back">< Back</button>
        <button class="page-button" id="station-next">Next ></button>
    </div>
</div>

<table id="frequent-affected-stations">
    <thead>
        <tr>
            <th>Station</th>
            <th># of Disruptions</th>
        </tr>
    </thead>
</table>

<script>
    const affectedStationsTableKeys = ['stationName', 'frequency'];
    const affectedStationsTable = document.getElementById('frequent-affected-stations');
    const stationPageDisplay = document.getElementById("station-page-display");
    const stations = <?php echo json_encode($affectedStations); ?>;
    const stationChunkSize = 25;
    let currentStationChunk = 0;

    let stationChunks = chunkify(stations, stationChunkSize);
    fillAffectedStations();

    const stationSearchInput = document.getElementById('stationSearch');
    stationSearchInput.addEventListener('input', () => {
        const query = stationSearchInput.value;
        const filteredStations = search(query, stations);
        stationChunks = chunkify(filteredStations, stationChunkSize);
        currentStationChunk = 0;
        fillAffectedStations();
    });

    const stationBackButton = document.getElementById('station-back');
    const stationNextButton = document.getElementById('station-next');
    stationBackButton.addEventListener('click', () => {
        if (currentStationChunk > 0) {
            currentStationChunk--;
            fillAffectedStations();
        }
    });
    stationNextButton.addEventListener('click', () => {
        if (currentStationChunk < stationChunks.length - 1) {
            currentStationChunk++;
            fillAffectedStations();
        }
    });

    function fillAffectedStations() {
        fillTable(affectedStationsTable, stationChunks, currentStationChunk, affectedStationsTableKeys, stationPageDisplay);
    }
</script>
