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

<table id="frequent-causes">
    <thead>
        <tr>
            <th>Cause</th>
            <th># of Disruptions</th>
        </tr>
    </thead>
</table>

<script>
    (function() {
        const elements = {
            table: document.getElementById('frequent-causes'),
            pageDisplay: document.getElementById('cause-page-display'),
            search: document.getElementById('causeSearch'),
            back: document.getElementById('cause-back'),
            next: document.getElementById('cause-next')
        };
        const tableCols = ['cause', 'frequency'];
        const data = <?php echo json_encode($causes); ?>;

        initTable(elements, tableCols, data);
    })();
</script>
