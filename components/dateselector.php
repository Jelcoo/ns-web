<?php
    require_once "./functions/ns_database.php";

    $dates = GetDisruptionDates();
?>

<div id="dataselector">
    <select id="display" name="display">
        <option value="current" default>Current</option>
        <option value="single_date">Single</option>
        <option value="range">Range</option>
    </select>
    <input type="date" id="startDate" value="<?php echo date('Y-m-d'); ?>">
    <input type="date" id="endDate" value="<?php echo date('Y-m-d'); ?>">
</div>

<script>
    const dates = <?php echo json_encode($dates); ?>;
    const rawDates = dates.map(date => date.date);

    const display = document.getElementById('display');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    
    startDate.style.display = 'none';
    endDate.style.display = 'none';

    display.value = getUrlQuery('display') ?? 'current';
    startDate.value = getUrlQuery('start');
    endDate.value = getUrlQuery('end');
    updateInputStyles(display.value);

    display.addEventListener('change', (event) => {
        const value = event.target.value;

        updateInputStyles(value);
        setUrlQuery(['display', value]);
    });

    startDate.addEventListener('change', (event) => {
        if (display.value === "single_date") {
            setUrlQuery(['start',  event.target.value], ['end', event.target.value]);
        }
        else if (display.value === "range") {
            setUrlQuery(['start',  event.target.value], ['end', endDate.value]);
        }
    });

    endDate.addEventListener('change', (event) => {
        if (display.value === "range") {
            setUrlQuery(['start', startDate.value], ['end', event.target.value]);
        }
    });

    function updateInputStyles(state) {
        if (state === "current") {
            startDate.style.display = 'none';
            endDate.style.display = 'none';
        } else if (state === "single_date") {
            startDate.style.display = 'block';
        } else if (state === "range") {
            startDate.style.display = 'block';
            endDate.style.display = 'block';
        }
    }
</script>
