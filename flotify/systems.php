<!DOCTYPE html>
<html lang="en">

<?php
$jsonData = file_get_contents('http://localhost/flotify/dataHandler.php?action=fetchLatest');
$data = json_decode($jsonData, true);
if (isset($data['error'])) {
    $errorMessage = $data['error'];
} else {
    $temperature = $data['temperature'];
    $humidity = $data['humidity'];
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systems</title>
    <link rel="stylesheet" href="css/systems.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 1,
                'wght' 400,
                'GRAD' 0,
                'opsz' 48
        }
    </style>


    <link href="https://cdn.osmbuildings.org/4.1.1/OSMBuildings.css" rel="stylesheet">

    <script src="https://cdn.osmbuildings.org/4.1.1/OSMBuildings.js"></script>


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <nav class="topnav">
        <div class="logo">
            <a href="https://www.youtube.com"><img src="img/floatify-logo-transparent-white.png" alt=""></a>
            <p class="logo-extension">SYSTEMS</p>
        </div>
        <ul>
            <li><a href="/html/index.html">Emergency Hotlines</a></li>
            <li><a href="/html/systems.html">Resources Used</a></li>
            <li><a href="/html/contacts.html">About Us</a></li>
        </ul>
    </nav>
    <section class="main-content">
        <div class="main-content-flex">
            <div class="side-contents">
                <div class="sensor-infos">
                    <div class="search-bar">
                        <span class="material-symbols-outlined">
                            search
                        </span>
                        <input type="text" placeholder="Search for Flotify Systems" class="search">
                    </div>
                    <div class="current-location">
                        <h2 class="sensor-type-heading">Device Current Location</h2>
                        <div class="current-location-container">
                            <span class="material-symbols-outlined">
                                my_location
                            </span>
                            <div class="location-contaner">
                                <p class="location-simplified" data-tooltip="Coordinates: 14.836375° N, 120.278112° E">
                                    35-A National Highway, Lower Kalaklan, Olongapo,
                                    Philippines</p>
                            </div>
                        </div>
                    </div>
                    <div class="weather-parameters-container">
                        <h2 class="sensor-type-heading">Weather Parameters</h2>
                        <div class="weather-parameter">
                            <span class="material-symbols-outlined">
                                thermostat
                            </span>
                            <div class="sensor-val-classification">
                                <h3 class="sensor-name">Temperature</h3>
                                <p class="sensor-classification">HOT sobra</p>
                            </div>
                            <h3 class="sensor-val-actual"><?= isset($temperature) ? htmlspecialchars($temperature) : "NaN" ?>°C</h3>
                        </div>
                        <div class="weather-parameter">
                            <span class="material-symbols-outlined">
                                humidity_percentage
                            </span>
                            <div class="sensor-val-classification">
                                <h3 class="sensor-name">Humidity</h3>
                                <p class="sensor-classification">Optimal</p>
                            </div>
                            <h3 class="sensor-val-actual"><?= isset($humidity) ? htmlspecialchars($humidity) : "NaN" ?>%</h3>
                        </div>
                        <div class="weather-parameter">
                            <span class="material-symbols-outlined">
                                air_purifier_gen
                            </span>
                            <div class="sensor-val-classification">
                                <h3 class="sensor-name">Air Quality</h3>
                                <p class="sensor-classification">Safe</p>
                            </div>
                        </div>
                    </div>
                    <div class="weather-indicators-container">
                        <div class="rain-sensor-classifications">
                            <div class="text-type-content-container">
                                <h3 class="classification-heading">
                                    Rain Intensity
                                </h3>
                                <h2 class="classification-simplified">
                                    <?= isset($data['rainIntensity']) ? htmlspecialchars($data['rainIntensity']) : "NaN" ?>
                                </h2>
                                <h3 class="classification-detailed">
                                    ~ 0.01 mm/h
                                </h3>
                            </div>
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/9d984846-cd9e-4cef-84b4-f28890870cf7/FTChl2O5SN.json" background="transparent" speed="1" style="width: 230px; height: 230px; margin-top: 90px; margin-left: auto;" direction="1" playMode="bounce" loop autoplay></dotlottie-player>
                        </div>
                        <div class="flood-level-classifications">
                            <div class="text-type-content-container">
                                <h3 class="classification-heading">
                                    Flood Levels
                                </h3>
                                <h2 class="classification-simplified">
                                    Safe
                                </h2>
                                <h3 class="classification-detailed"> ~
                                    <?= isset($data['waterlevel_ultrasonic']) ? htmlspecialchars($data['waterlevel_ultrasonic']) : "NaN" ?> meters
                                </h3>
                            </div>
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script><dotlottie-player src="https://lottie.host/b7e6971d-7845-4491-97c4-a8c32cccbddf/ZqtIR8sy8M.json" background="transparent" speed="1" style="width: 320px; height: 320px; margin-left: auto; margin-top: 150px; margin-right: -60px;" direction="1" playMode="bounce" loop controls autoplay></dotlottie-player>
                        </div>
                    </div>
                </div>

            </div>
            <div id="map">

            </div>
        </div>
        <script src="./js/maps.js"></script>
        <script src="./js/switch-location.js"></script>
        <script src="./js/processData.js"></script>
        <script>
            function toggleTextContainer() {
                const warningContainer = document.querySelector('.warning-container');
                const textContainer = document.querySelector('.text-container');

                // Check if the container is already expanded
                if (!warningContainer.classList.contains('expanded')) {
                    warningContainer.classList.add('expanded'); // Start expanding
                    warningContainer.addEventListener('transitionend', function() {
                        textContainer.style.display = 'block'; // Show text after expansion
                    }, {
                        once: true
                    }); // Ensure the listener is removed after execution
                } else {
                    textContainer.style.display = 'none'; // Hide text immediately
                    warningContainer.classList.remove('expanded'); // Then start collapsing
                }
            }
        </script>
    </section>

</body>

</html>