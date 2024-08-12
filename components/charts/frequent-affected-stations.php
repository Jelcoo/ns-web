<?php
    require_once "./functions/ns_database.php";

    $affectedStations = GetStatAffectedStations();
?>

<input type="text" id="search" placeholder="Search" />

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
    const chunkSize = 25;
    let currentChunk = 0;

    let stationChunks = chunkify(stations, chunkSize);
    fillTable(stationChunks[currentChunk]);

    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', () => {
        const query = searchInput.value;
        const filteredStations = search(query, stations);
        stationChunks = chunkify(filteredStations, chunkSize);
        currentChunk = 0;
        fillTable(stationChunks[currentChunk]);
    });

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

    function chunkify(data, chunkSize) {
        const chunks = [];
        for (let i = 0; i < data.length; i += chunkSize) {
            chunks.push(data.slice(i, i + chunkSize));
        }
        return chunks;
    }
    function fillTable(chunkData) {
        table.innerHTML = '';
        chunkData?.forEach(station => {
            const row = table.insertRow();
            const stationName = row.insertCell();
            const frequency = row.insertCell();
            stationName.innerHTML = station.stationName;
            frequency.innerHTML = station.frequency;
        });

        const pageDisplay = document.getElementById('page-display');
        pageDisplay.innerHTML = `Page ${currentChunk + 1} of ${Math.max(stationChunks.length, 1)}`;
    }
    function search(query, data) {
        return data.filter(station => station.stationName.toLowerCase().includes(query.toLowerCase()));
    }
</script>
