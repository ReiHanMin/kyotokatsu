document.addEventListener("DOMContentLoaded", function() {
    const barbershopCard = document.querySelector('.barbershop-card');

    if (barbershopCard) {
        const openingTime = barbershopCard.getAttribute('data-opening-time');
        const closingTime = barbershopCard.getAttribute('data-closing-time');

        if (openingTime && closingTime) {


            const now = new Date();
            const nowJST = new Date(now.toLocaleString("en-US", { timeZone: "Asia/Tokyo" }));


            function parseTime(timeStr) {
   
    
    const timeParts = timeStr.match(/(\d+):(\d+) (AM|PM)/i);
  
    
    if (timeParts && timeParts.length === 4) {
        let hours = parseInt(timeParts[1]);
        const minutes = parseInt(timeParts[2]);
        const period = timeParts[3].toUpperCase();



        if (period === "PM" && hours !== 12) {
            hours += 12;
        } else if (period === "AM" && hours === 12) {
            hours = 0;
        }

        const parsedDate = new Date(nowJST.getFullYear(), nowJST.getMonth(), nowJST.getDate(), hours, minutes);


        return parsedDate;
    }
    
    console.error('Failed to parse time:', timeStr);
    return null;
}


            const openTime = parseTime(openingTime);
            const closeTime = parseTime(closingTime);


            if (openTime && closeTime) {
                let status;
                const statusElement = barbershopCard.querySelector('.status');

                if (nowJST >= openTime && nowJST < closeTime) {
                    if (nowJST >= new Date(closeTime.getTime() - 3600000)) {
                        status = 'Closes soon at ' + closingTime;
                        statusElement.className = 'status status-closing-soon';
                    } else {
                        status = 'Open now until ' + closingTime;
                        statusElement.className = 'status status-open';
                    }
                } else if (nowJST < openTime && nowJST >= new Date(openTime.getTime() - 3600000)) {
                    status = 'Opens soon at ' + openingTime;
                    statusElement.className = 'status status-opening-soon';
                } else {
                    status = 'Closed, opens at ' + openingTime;
                    statusElement.className = 'status status-closed';
                }

                statusElement.innerText = status;
            } else {
                console.error('Parsed opening or closing time is invalid.');
            }
        } else {
            console.error('Opening or Closing time is missing.');
        }
    } else {
        console.error('Barbershop card not found.');
    }
});
