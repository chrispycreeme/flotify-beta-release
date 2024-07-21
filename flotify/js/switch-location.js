var locations = {
    'location1': [14.836375, 120.278112],
    'location2': [9.776641697816485, 118.76523128023013]
};

var searchBar = document.querySelector('.search');

searchBar.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        searchLocation(e.target.value);
    }
});

function searchLocation(query) {
    if (locations[query]) {
        map.flyTo(locations[query], 18);
    }
}