const socket = io("wss://nsws.jelco.xyz", {
    transports: ['websocket']
});

const sprinterIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/sprinter.svg'
});
const sprinterFocusIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/sprinter_focused.svg'
});
const icIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/intercity.svg'
});
const icFocusIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/intercity_focused.svg'
});
const arrivaIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/arriva.svg'
});
const arrivaIconIcon = L.icon({
    iconSize: [25, 30],
    popupAnchor: [0, 0],
    iconUrl: 'assets/img/icon/arriva_focused.svg'
});

function trainToTooltip(train) {
    return `Type: ${train.type}<br>Snelheid: ${Math.round(train.snelheid, 0)} km/h`;
}
