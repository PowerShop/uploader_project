// Set the countdown time to 5 seconds
var countdownTime = 5;
var countdownElement = document.getElementById("countdown");

// Define a function to update the countdown text
function updateCountdown() {
    countdownElement.innerHTML = "You will be redirected to Home in " + countdownTime + " seconds.";
    countdownTime--;
    // If the countdown reaches 0, redirect to index.php
    if (countdownTime < 0) {
        window.location.href = "?page=home";
    }
}

// Call the updateCountdown function every second
setInterval(updateCountdown, 1000);