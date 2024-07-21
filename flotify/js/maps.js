var map = L.map('map', {
    minZoom: 5,
    maxBounds: [
        [4.215806, 116.954513],
        [21.321780, 126.807617]
    ],
    maxBoundsViscosity: 1.0
});

map.setView([14.836375, 120.278112], 5);


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'

}).addTo(map);


var legend = L.control({ position: 'bottomright' });

legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'legend');

    div.innerHTML += '<h4>Legend</h4>';
    div.innerHTML += '<i style="background: url(assets/icons/location_on_48dp_FILL1_wght400_GRAD0_opsz48.png) no-repeat center; width: 10px; height: 10px; display: inline-block;"></i> Station Location<br>';
    div.innerHTML += '<i style="background: url(assets/icons/shield_with_house_48dp_FILL1_wght300_GRAD200_opsz20.png) no-repeat center; width: 10px; height: 10px; display: inline-block;"></i> Evacuation Location<br>';

    return div;
};

var warningControl = L.control({ position: 'topleft' }); // You can change the position

warningControl.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'warning-container');
    div.innerHTML = `
        <style>
        .warning-container {
    display: flex;
    background-color: #202235;
    border-radius: 25px;
    width: 85px;
    max-width: 50%;
    padding: 20px 20px 20px 20px;
    align-items: center;
    transition: width 0.5s ease;
    
}

.warning-container span {
    color: #00F0B5;
    border: 3.5px solid #00F0B5;
    border-radius: 50%;
    padding: 10px;
    font-size: 20px;
    text-align: center;
    align-items: center;
    display: flex;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}

.text-container {
    margin-left: 15px;
    width: 83%;
    display: none;
}

.text-container h1 {
    font-size: 20px;
    color: #fcfcfc;
    margin-bottom: 0;
    margin-top: 0;
}

.text-container p {
    font-size: 14px;
    color: #DFE2E1;
    margin-bottom: 3px;
    margin-top: 3px;
    font-style: italic;
}

p.areas {
    color: #00F0B5;
    margin-bottom: 0;
    margin-top: 10px;
    font-style: normal;
    font-size: 16px;
    background-color: #2e3049;
    font-weight: bold;
    border-radius: 25px;
    padding: 10px;
    padding-left: 25px;
}

.material-symbols-outlined:hover {
    border-color: #45475f;
    color: #45475f;
}

.warning-container.expanded {
    width: 50%;
}
        </style>
        <span class="material-symbols-outlined" onclick="toggleTextContainer()">
            warning
        </span>
        <div class="text-container">
            <h1>Flood Level Detected: Level 1 (1 meter)</h1>
            <p>There is a high chance of flooding in the following areas. Please take necessary precautions.</p>
            <p class="areas">Sta. Rita</p>
        </div>
        <script>
        function toggleTextContainer() {
            const warningContainer = document.querySelector('.warning-container');
            const textContainer = document.querySelector('.text-container');
    
            // Check if the container is already expanded
            if (!warningContainer.classList.contains('expanded')) {
                warningContainer.classList.add('expanded');
                warningContainer.addEventListener('transitionend', function() {
                    textContainer.style.display = 'block';
                }, { once: true });
            } else {
                textContainer.style.display = 'none';
                warningContainer.classList.remove('expanded');
            }
        }
    </script>
    `;
    return div;
};

// Add the warning control to the map
warningControl.addTo(map);

legend.addTo(map);

var stationLocation = L.icon({
    iconUrl: 'assets/icons/location_on_48dp_FILL1_wght400_GRAD0_opsz48.png',
    iconSize: [40, 40],
});

var marker = L.marker([14.836375, 120.278112], { icon: stationLocation }).addTo(map);
// var marker2 = L.marker([9.776641697816485, 118.76523128023013], { icon: stationLocation }).addTo(map);

marker.on('click', function (e) {
    map.flyTo(e.target.getLatLng(), 18);
});

// marker2.on('click', function (e) {
//     map.flyTo(e.target.getLatLng(), 18);
// });

// var evacuationLocation = L.icon({
//     iconUrl: 'assets/icons/shield_with_house_48dp_FILL1_wght300_GRAD200_opsz20.png',
//     iconSize: [40, 40],
// });

// var evacuation1 = L.marker([14.849261885135427, 120.31312129680448], { icon: evacuationLocation }).addTo(map);

// evacuation1.on('click', function (e) {
//     map.flyTo(e.target.getLatLng(), 18);
// });

// var circle = L.circle([14.857697047236142, 120.29975802571654], {
//     color: 'red',      // Color of the circle
//     fillColor: '#f03', // Fill color of the circle
//     fillOpacity: 0.5,  // Fill opacity of the circle
//     radius: 500          // Radius in meters
// }).addTo(map);

