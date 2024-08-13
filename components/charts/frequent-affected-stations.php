<?php
    require_once "./functions/ns_database.php";

    $affectedStations = GetStatAffectedStations();
?>

<input type="text" id="search" placeholder="Search" />
<div id="page-selectors">
    <span id="page-display"></span>
    <div id="page-buttons">
        <button id="back">< Back</button>
        <button id="next">Next ></button>
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
        for (let i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
        chunkData?.forEach(station => {
            const row = table.insertRow();
            const stationName = row.insertCell();
            const frequency = row.insertCell();
            stationName.innerHTML = station.stationName;
            frequency.innerHTML = station.frequency;
        });

        const pageDisplay = document.getElementById('page-display');
        pageDisplay.innerHTML = `Page <strong>${currentChunk + 1}</strong> of <strong>${Math.max(stationChunks.length, 1)}</strong>`;
    }
    function search(query, data) {
        return data.filter(station => station.stationName.toLowerCase().includes(query.toLowerCase()));
    }
</script>

<style>
    span, th, td {
        color: #ffffff;
    }

    #search {
        width: 100%;
        padding: 0.5rem;
        box-sizing: border-box;
        border: none;
        border-radius: 5px;
        margin-bottom: 0.5rem;
    }
    #page-selectors {
        text-align: center;
        margin-bottom: 0.5rem;
    }
    #page-buttons {
        margin-top: 0.2rem;
    }
    #back, #next {
        padding: 0.2rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th:first-child, td:first-child {
        text-align: left;
    }
    th:last-child, td:last-child {
        text-align: right;
    }
</style>
