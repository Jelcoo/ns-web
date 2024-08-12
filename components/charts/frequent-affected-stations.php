<?php
    require_once "./functions/ns_database.php";

    $affectedStations = GetStatAffectedStations();
?>

<table id="frequent-affected-stations">
    <thead>
        <tr>
            <th>Station</th>
            <th># of Disruptions</th>
        </tr>
    </thead>
</table>
<span id="page-display"></span>
<button id="back">< Back</button>
<button id="next">Next ></button>

<script>
    const table = document.getElementById('frequent-affected-stations');
    const stations = <?php echo json_encode($affectedStations); ?>;
    const stationChunks = [];
    let currentChunk = 0;

    const chunkSize = 25;
    for (let i = 0; i < stations.length; i += chunkSize) {
        const chunk = stations.slice(i, i + chunkSize);
        stationChunks.push(chunk);
    }
    fillTable(stationChunks[currentChunk]);

    const backButton = document.getElementById('back');
    const nextButton = document.getElementById('next');
    backButton.addEventListener('click', () => {
        if (currentChunk > 0) {
            currentChunk--;
            fillTable(stationChunks[currentChunk]);
        }
    });
    nextButton.addEventListener('click', () => {
        if (currentChunk < stationChunks.length - 1) {
            currentChunk++;
            fillTable(stationChunks[currentChunk]);
        }
    });

    function fillTable(chunkData) {
        table.innerHTML = '';
        chunkData.forEach(station => {
            const row = table.insertRow();
            const stationName = row.insertCell();
            const frequency = row.insertCell();
            stationName.innerHTML = station.stationName;
            frequency.innerHTML = station.frequency;
        });

        const pageDisplay = document.getElementById('page-display');
        pageDisplay.innerHTML = `Page ${currentChunk + 1} of ${stationChunks.length}`;
    }
</script>
