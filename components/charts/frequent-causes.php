<?php
    require_once "./functions/ns_database.php";

    $causes = GetStatCauses();
?>

<input type="text" class="search" id="causeSearch" placeholder="Search" />
<div class="page-selectors">
    <span class="page-display" id="cause-page-display"></span>
    <div class="page-buttons">
        <button class="page-button" id="cause-back">< Back</button>
        <button class="page-button" id="cause-next">Next ></button>
    </div>
</div>

<table id="frequent-affected-causes">
    <thead>
        <tr>
            <th>Cause</th>
            <th># of Disruptions</th>
        </tr>
    </thead>
</table>

<script>
    const affectedCausesTableKeys = ['cause', 'frequency'];
    const affectedCausesTable = document.getElementById('frequent-affected-causes');
    const causePageDisplay = document.getElementById("cause-page-display");
    const causes = <?php echo json_encode($causes); ?>; 
    const causeChunkSize = 25;
    let currentCauseChunk = 0;

    let causesChunks = chunkify(causes, causeChunkSize);
    fillCauses();

    const causeSearchInput = document.getElementById('causeSearch');
    causeSearchInput.addEventListener('input', () => {
        const query = causeSearchInput.value;
        const filteredCauses = search(query, causes);
        causesChunks = chunkify(filteredCauses, causeChunkSize);
        currentCauseChunk = 0;
        fillCauses();
    });

    const causeBackButton = document.getElementById('cause-back');
    const causeNextButton = document.getElementById('cause-next');
    causeBackButton.addEventListener('click', () => {
        if (currentCauseChunk > 0) {
            currentCauseChunk--;
            fillCauses();
        }
    });
    causeNextButton.addEventListener('click', () => {
        if (currentCauseChunk < causesChunks.length - 1) {
            currentCauseChunk++;
            fillCauses();
        }
    });

    function fillCauses() {
        fillTable(affectedCausesTable, causesChunks, currentCauseChunk, affectedCausesTableKeys, causePageDisplay);
    }
</script>
