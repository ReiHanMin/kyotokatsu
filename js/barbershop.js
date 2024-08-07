document.addEventListener("DOMContentLoaded", function() {
    // Get user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function showPosition(position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;
        console.log(`User Latitude: ${userLat}, User Longitude: ${userLng}`);

        const barbershopData = [];

        // Iterate over barbershop cards
        const barbershopCards = document.querySelectorAll('.barbershop-card');
        barbershopCards.forEach(card => {
            const barberLat = parseFloat(card.getAttribute('data-latitude'));
            const barberLng = parseFloat(card.getAttribute('data-longitude'));
            console.log(`Barber Latitude: ${barberLat}, Barber Longitude: ${barberLng}`);
            
            const distance = calculateDistance(userLat, userLng, barberLat, barberLng);
            console.log(`Distance for ${card.querySelector('h3').innerText}: ${distance} kms`);

            barbershopData.push({ card, distance });
        });

        // Sort the barbershop data by distance
        barbershopData.sort((a, b) => a.distance - b.distance);

        // Clear the container and re-append the sorted cards
        const container = document.querySelector('.barbershop-cards');
        container.innerHTML = '';
        barbershopData.slice(0, 3).forEach(({ card, distance }) => {
            card.querySelector('.distance').innerText = `Distance: ${distance.toFixed(2)} kms`;
            card.classList.remove('hidden');
            container.appendChild(card);
        });
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = 
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in km
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.getElementById('search-bar');
    const findBarberButton = document.getElementById('find-barber');
    const filterButtons = document.querySelectorAll('.filter-buttons button');
    const barbershopCardsContainer = document.getElementById('barbershop-cards');

    findBarberButton.addEventListener('click', function() {
        // Implement search functionality here
    });

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterType = this.getAttribute('data-filter');
            // Implement filtering functionality here
        });
    });

    