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
