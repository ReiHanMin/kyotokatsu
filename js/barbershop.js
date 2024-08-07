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

        // Iterate over barbershop cards
        const barbershopCards = document.querySelectorAll('.barbershop-card');
        barbershopCards.forEach(card => {
            const latitude = parseFloat(card.getAttribute('data-latitude'));
            const longitude = parseFloat(card.getAttribute('data-longitude'));
            const openingTime = card.getAttribute('data-opening-time');
            const closingTime = card.getAttribute('data-closing-time');

            // Debugging logs
            console.log('Opening Time:', openingTime);
            console.log('Closing Time:', closingTime);

            // Calculate distance
            const distance = calculateDistance(userLat, userLng, latitude, longitude);
            card.querySelector('.distance').innerText = `Distance: ${distance.toFixed(2)} kms`;

            // Determine opening/closing status
            var now = new Date();
            var nowJST = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Tokyo"}));

            function parseTime(timeStr) {
                var timeParts = timeStr.match(/(\d+):(\d+) (AM|PM)/i);
                if (timeParts && timeParts.length === 4) {
                    var hours = parseInt(timeParts[1]);
                    var minutes = parseInt(timeParts[2]);
                    var period = timeParts[3].toUpperCase();

                    if (period === "PM" && hours !== 12) {
                        hours += 12;
                    } else if (period === "AM" && hours === 12) {
                        hours = 0;
                    }

                    return new Date(nowJST.getFullYear(), nowJST.getMonth(), nowJST.getDate(), hours, minutes);
                }
                return null; // If the time format is incorrect, return null
            }

            var openTime = parseTime(openingTime);
            var closeTime = parseTime(closingTime);

            // Debugging logs
            console.log('Open Time:', openTime);
            console.log('Close Time:', closeTime);

            if (openTime && closeTime) {
                var status;
                var nextOpeningTime = '';

                if (nowJST >= openTime && nowJST <= closeTime) {
                    if (nowJST >= subtractMinutes(closeTime, 60)) {
                        status = 'Closes soon';
                    } else {
                        status = 'Open';
                    }
                } else if (nowJST < openTime && nowJST >= subtractMinutes(openTime, 60)) {
                    status = 'Opens soon';
                } else {
                    status = 'Closed';
                    nextOpeningTime = ', opens ' + formatTime(openTime);
                }

                card.querySelector('.status').innerText = status + nextOpeningTime;

                function addMinutes(time, minsToAdd) {
                    return new Date(time.getTime() + minsToAdd * 60000);
                }

                function subtractMinutes(time, minsToSubtract) {
                    return new Date(time.getTime() - minsToSubtract * 60000);
                }

                function formatTime(date) {
                    var hours = date.getHours();
                    var minutes = date.getMinutes();
                    if (minutes < 10) {
                        minutes = '0' + minutes;
                    }
                    return hours + ':' + minutes;
                }

                card.classList.remove('hidden');
            } else {
                card.style.display = 'none';
            }
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
