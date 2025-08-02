// Start checking the session every 10 seconds
const sessionCheckInterval = setInterval(() => {
    fetch(window.APP.BASE_URL + "auth/checkSession", {
        method: "POST",
        headers: { "Content-Type": "application/json" }
    })
        .then(res => res.json())
        .then(data => {
            if (!data.active) {
                clearInterval(sessionCheckInterval);

                // Set initial countdown time
                let timeLeft = 5;

                // Create the first warning toast
                let countdownToast = toast.warning(`La sesión se cerrará en ${timeLeft} segundos...`);

                // Start a countdown interval that updates the message every second
                const countdownInterval = setInterval(() => {
                    timeLeft--;

                    // Remove the previous toast and show the updated one
                    countdownToast = toast.warning(`La sesión se cerrará en ${timeLeft} segundos...`);

                    // When the countdown reaches 0, stop the interval and redirect
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);

                        // Redirect after a brief delay
                        setTimeout(() => {
                            window.location.href = window.APP.BASE_URL + "auth/login?timeout=1";
                        }, 500); // Small delay before redirecting for a smooth UX
                    }
                }, 1000); // Update every second
            }
        })
        .catch(error => {
            console.error("Error checking session:", error);
        });
}, 10000); // Check session every 10 seconds
