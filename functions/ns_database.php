<?php

function GetTrainDisruptionsDb($startDate, $endDate) {
    global $conn;

    $query = $conn->query("SELECT * FROM disruptions WHERE timeStart BETWEEN '$startDate' AND '$endDate';");
    $result = $query->fetch_all(MYSQLI_ASSOC);

    return $result;
}
