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

    $query = $conn->prepare("SELECT * FROM disruptions WHERE timeStart > ? AND timeEnd < ?;");
    $query->bind_param("ss", $startDate, $endDate);
    $query->execute();
    $result = $query->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}
