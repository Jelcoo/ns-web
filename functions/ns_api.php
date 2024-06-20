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

function GetTrainDisruptions() {
    if (apcu_exists("current_disruptions")) {
        return apcu_fetch("current_disruptions");
    }

    $ch = InitCurl("https://gateway.apiportal.ns.nl/reisinformatie-api/api/v3/disruptions");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    apcu_store("current_disruptions", $data, 60);

    return $data;
}

function GetTrainDisruptionsGeo() {
    if (apcu_exists("current_disruptions_geo")) {
        return apcu_fetch("current_disruptions_geo");
    }

    $ch = InitCurl("https://gateway.apiportal.ns.nl/Spoorkaart-API/api/v1/storingen");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    apcu_store("current_disruptions_geo", $data, 60);

    return $data;
}
