let currentFeatureIndex = 0;

document.getElementById('nextFeatureBtn').addEventListener('click', function () {
    const features = [
        {
            name: "Solar Panel",
            description: "5V KEMERUT",
            explanationDetail: "kasi cool ako",
            iconName: "solar_power",
            modelRotation: "0.03rad 1.39rad 0m",
            modelTarget: "-8.48m 415.38m 76.69m"
        },
        {
            name: "Rain Gauge",
            description: "Hall Effect Tipping Bucket Mechanism",
            explanationDetail: "kasi cool ako ulit",
            iconName: "speed",
            modelRotation: "0.57rad 1.34rad 0m",
            modelTarget: '3.41m 477.82m 36.78m'
        },
        {
            name: "Float Switch",
            description: "gage d ko alam lalagay ko dito",
            explanationDetail: "whaaaaa",
            iconName: "water_lux",
            modelRotation: "-0.78rad 1.88rad 0m",
            modelTarget: '-59.45m 129.76m 52.05m'
        },
        {
            name: "Water Level Sensor",
            description: "mura lang to",
            explanationDetail: "asdasdasd",
            iconName: "straighten",
            modelRotation: "0.82rad 1.82rad 0m",
            modelTarget: '63.78m 140.44m 63.31m'
        },
        {
            name: "Rain Sensor",
            description: "Rain Intensity eme eme",
            explanationDetail: "1286216124",
            iconName: "rainy",
            modelRotation: "-1.11rad 1.47rad 0m",
            modelTarget: '-13.00m 510.69m -18.29m'
        },
        {
            name: "Main System Unit",
            description: "lagyanan",
            explanationDetail: "woahh daming laman",
            iconName: "dns",
            modelRotation: "2.46rad 1.79rad 0m",
            modelTarget: '58.42m 247.14m -50.02m'
        },
        {
            name: "Siren",
            description: "maingay",
            explanationDetail: "grabe daldal",
            iconName: "notification_important",
            modelRotation: "0.81rad 1.10rad 0m",
            modelTarget: '6.78m 618.29m -20.48m'
        },
        {
            name: "Ultrasonic Sensor",
            description: "baha",
            explanationDetail: "tubig",
            iconName: "flood",
            modelRotation: "-0.57rad 1.93rad 0m",
            modelTarget: '-7.18m 226.14m 197.85m'
        }
    ];

    function updateFeature() {
        document.querySelector('.feature-name').textContent = features[currentFeatureIndex].name;
        document.querySelector('.feature-specified').textContent = features[currentFeatureIndex].description;
        document.querySelector('.feature-description').textContent = features[currentFeatureIndex].explanationDetail;
        document.getElementById('icon').textContent = features[currentFeatureIndex].iconName;

        const modelViewers = document.querySelectorAll('model-viewer');
        modelViewers.forEach(modelViewer => {
            
            const [yaw, pitch, radius] = features[currentFeatureIndex].modelRotation.split(' ');
            modelViewer.setAttribute('camera-orbit', `${yaw} ${pitch} ${radius}`);

            const target = features[currentFeatureIndex].modelTarget;
            modelViewer.setAttribute('camera-target', target);
        });
    }

    currentFeatureIndex = (currentFeatureIndex + 1) % features.length;

    updateFeature();
});

updateFeature();