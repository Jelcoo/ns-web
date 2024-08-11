<?php

function InitCurl($url) {
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Ocp-Apim-Subscription-Key: ' . getenv("NS_SUBSCRIPTION_KEY")));

    return $ch;
}

function GetTrainTracksGeo() {
    if (apcu_exists("traintracks")) {
        return apcu_fetch("traintracks");
    }

    $ch = InitCurl("https://gateway.apiportal.ns.nl/Spoorkaart-API/api/v1/spoorkaart");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    apcu_store("traintracks", $data, 24 * 60 * 60);

    return $data;
}

function GetTrainPositions() {
    $ch = InitCurl("https://gateway.apiportal.ns.nl/virtual-train-api/api/vehicle");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    return $data;
}

function GetTrainByRitnr($ritnr) {
    $ch = InitCurl("https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/journey?train=$ritnr");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    return $data;
}
