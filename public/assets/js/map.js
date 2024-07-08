function makeMap(key, minZoom, maxZoom, tracks) {
    const map = L.map('map').setView([52.13580717626822, 5.746366037663725], 8);

    L.tileLayer(`https://{s}.tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=${key}`, {
        minZoom,
        maxZoom,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    tracks.payload.features.forEach(feature => {
        const trackStyle = {
            "color": "#919191",
            "weight": 2
        };

        L.geoJSON(feature, {
            style: trackStyle
        }).addTo(map);
    });

    return map;
}
