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
    (function() {
        const elements = {
            table: document.getElementById('frequent-affected-stations'),
            pageDisplay: document.getElementById('station-page-display'),
            search: document.getElementById('stationSearch'),
            back: document.getElementById('station-back'),
            next: document.getElementById('station-next')
        };
        const tableCols = ['stationName', 'frequency'];
        const data = <?php echo json_encode($affectedStations); ?>;

        initTable(elements, tableCols, data);
    })();
</script>
