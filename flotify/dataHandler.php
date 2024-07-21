<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

class DeviceA {
    private $link;

    function __construct() {
        $this->connect();
    }

    function __destruct() {
        mysqli_close($this->link);
    }

    function connect() {
        $this->link = mysqli_connect('localhost', 'root', '', 'flotifytest');
        if (!$this->link) {
            die(json_encode(['error' => 'Cannot connect to the DB']));
        }
    }

    function storeInDB($rainAnalog, $rainIntensity, $waterlevel_ultrasonic, $temperature, $humidity) {
        $stmt = mysqli_prepare($this->link, "INSERT INTO devicea (rainAnalog, rainIntensity, waterlevel_ultrasonic, temperature, humidity) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $rainAnalog, $rainIntensity, $waterlevel_ultrasonic, $temperature, $humidity);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => 'Data inserted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to insert data']);
        }
        mysqli_stmt_close($stmt);
    }

    function fetchLatest() {
        $query = "SELECT * FROM devicea ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($this->link, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $latestData = mysqli_fetch_assoc($result);
            echo json_encode($latestData);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    }
}

$deviceA = new DeviceA();

if (isset($_GET['action']) && $_GET['action'] == 'fetchLatest') {
    $deviceA->fetchLatest();
} elseif (isset($_GET['rainAnalog'], $_GET['rainIntensity'], $_GET['waterlevel_ultrasonic'], $_GET['temperature'], $_GET['humidity'])) {
    $deviceA->storeInDB($_GET['rainAnalog'], $_GET['rainIntensity'], $_GET['waterlevel_ultrasonic'], $_GET['temperature'], $_GET['humidity']);
} else {
    echo json_encode(['error' => 'Missing parameters']);
}
?>