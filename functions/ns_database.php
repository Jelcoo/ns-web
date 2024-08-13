<?php

function GetActiveTrainDisruptions() {
    global $conn;

    $query = $conn->prepare("SELECT * FROM disruptions WHERE timeEnd IS NULL AND stationsGeo IS NOT NULL;");
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}

function GetTrainDisruptionsBetween($startDate, $endDate) {
    global $conn;

    if ($startDate == $endDate) {
        $query = $conn->prepare("SELECT * FROM disruptions WHERE timeStart > DATE(?) AND timeStart < DATE(?) + INTERVAL 1 DAY");
        $query->bind_param("ss", $startDate, $startDate);
    } else {
        $query = $conn->prepare("SELECT * FROM disruptions WHERE DATE(timeStart) >= ? AND DATE(timeEnd) <= ?;");
        $query->bind_param("ss", $startDate, $endDate);
    }
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}

function GetDisruptionDates() {
    global $conn;

    $query = $conn->prepare("SELECT DATE(timeStart) AS date, COUNT(timeStart) AS value FROM disruptions GROUP BY DATE(timeStart);");
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}

function GetStatAffectedStations() {
    global $conn;

    $query = $conn->prepare("SELECT jt.value AS stationName, COUNT(jt.value) AS frequency FROM disruptions, JSON_TABLE(route, '$[0][*]' COLUMNS (value VARCHAR(255) PATH '$.value')) AS jt WHERE jt.value NOT LIKE 'DISRUPTION' GROUP BY jt.value ORDER BY frequency DESC;");
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}

function GetStatCauses() {
    global $conn;

    $query = $conn->prepare("SELECT `cause`, COUNT(`cause`) AS frequency FROM `disruptions` GROUP BY `cause` ORDER BY frequency DESC;
");
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}
