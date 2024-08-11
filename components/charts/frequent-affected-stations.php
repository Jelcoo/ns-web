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

<script>
    const table = document.getElementById('frequent-affected-stations');
    const stations = <?php echo json_encode($affectedStations); ?>;
    const stationChunks = [];

    const chunkSize = 10;
    for (let i = 0; i < stations.length; i += chunkSize) {
        const chunk = stations.slice(i, i + chunkSize);
        stationChunks.push(chunk);
    }

    stationChunks[0].forEach(station => {
        const row = table.insertRow();
        const stationName = row.insertCell();
        const frequency = row.insertCell();
        stationName.innerHTML = station.stationName;
        frequency.innerHTML = station.frequency;
    });
</script>
