<?php
    require_once "./functions/ns_database.php";

    $worstDays = GetStatMostAffectedDay();
?>

<input type="text" class="search" id="dateSearch" placeholder="Search" />
<div class="page-selectors">
    <span class="page-display" id="dates-page-display"></span>
    <div class="page-buttons">
        <button class="page-button" id="dates-back">< Back</button>
        <button class="page-button" id="dates-next">Next ></button>
    </div>
</div>

<table id="frequent-dates">
    <thead>
        <tr>
            <th>Date</th>
            <th># of Disruptions</th>
        </tr>
    </thead>
</table>

<script>
    (function() {
        const elements = {
            table: document.getElementById('frequent-dates'),
            pageDisplay: document.getElementById('dates-page-display'),
            search: document.getElementById('dateSearch'),
            back: document.getElementById('dates-back'),
            next: document.getElementById('dates-next')
        };
        const tableCols = ['date', 'frequency'];
        const data = <?php echo json_encode($worstDays); ?>;

        initTable(elements, tableCols, data);
    })();
</script>

