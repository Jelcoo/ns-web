<?php

function InitCurl($url) {
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Ocp-Apim-Subscription-Key: ' . getenv("NS_SUBSCRIPTION_KEY")));

    return $ch;
}

function GetTrainTracksGeo() {
    $ch = InitCurl("https://gateway.apiportal.ns.nl/Spoorkaart-API/api/v1/spoorkaart");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    return $data;
}

function GetTrainDisruptions() {
    $ch = InitCurl("https://gateway.apiportal.ns.nl/reisinformatie-api/api/v3/disruptions");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    return $data;
}

function GetTrainDisruptionsGeo() {
    $ch = InitCurl("https://gateway.apiportal.ns.nl/Spoorkaart-API/api/v1/storingen");

    $json = curl_exec($ch);
    $data = json_decode($json, true);

    return $data;
}
