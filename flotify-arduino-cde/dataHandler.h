#include <avr/pgmspace.h>

const char PHPGetProcess[] PROGMEM = R"=====(
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auto Send Data</title>
</head>

<body>
    <script>
        setInterval(function() {
            fetch('/sensorValues')
                .then(response => response.json())
                .then(data => {
                    let params = new URLSearchParams({
                        rainAnalog: data.rainAnalog,
                        rainIntensity: data.rainIntensity,
                        waterlevel_ultrasonic: data.waterlevel_ultrasonic,
                        temperature: data.temperature,
                        humidity: data.humidity
                    }).toString();

                    fetch(`http://127.0.0.1/flotify/dataHandler.php?${params}`, {
                        method: 'GET',
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                })
                .catch((error) => {
                    console.error('Error fetching sensor values:', error);
                });
        }, 5123);
    </script>
</body>

</html>
)=====";
