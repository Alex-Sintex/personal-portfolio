// Set timezone to Mexico City in JavaScript
function updateTime() {
    var options = { timeZone: "America/Mexico_City", hour12: true };
    var now = new Date().toLocaleString("en-US", options); // Get current time in Mexico City

    // Update the displayed time
    document.getElementById("timeDisplay").innerHTML = now;
}

// Update time every second (1000 milliseconds)
setInterval(updateTime, 1000);