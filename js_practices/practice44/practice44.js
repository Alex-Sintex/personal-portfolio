let countdownInterval;

function startAlarm() {
  let seconds = parseInt(document.getElementById("time").value, 10);
  let alarmText = document.getElementById("alarmText");

  clearInterval(countdownInterval);

  if (!isNaN(seconds) && seconds > 0) {
    let remaining = seconds;
    swal("Countdown started: " + remaining + " seconds left");

    countdownInterval = setInterval(() => {
      remaining--;

      if (remaining >= 0) {
        swal("Time left: " + remaining + " seconds");
        alarmText.style.color = "green";
      } else {
        clearInterval(countdownInterval);
        // Typewriter effect for "Time's up!"
        typeWriter("Time's up!", alarmText, 150);
        alarmText.style.color = "red";
        alarmText.style.textTransform = "uppercase";

        // 🎉 Launch confetti
        launchConfetti();
      }
    }, 1000);
  } else {
    swal("Please enter a valid number of seconds.");
    alarmText.textContent = "No time set!";
    alarmText.style.color = "black";
    alarmText.style.textTransform = "uppercase";
  }
}

// Typewriter animation
function typeWriter(text, element, speed = 100) {
  element.textContent = "";
  let i = 0;
  let interval = setInterval(() => {
    element.textContent += text.charAt(i);
    i++;
    if (i >= text.length) clearInterval(interval);
  }, speed);
}

// Confetti animation
function launchConfetti() {
  const duration = 3 * 1000; // 3 seconds
  const end = Date.now() + duration;

  (function frame() {
    confetti({
      particleCount: 5,
      angle: 60,
      spread: 55,
      origin: { x: 0 },
    });
    confetti({
      particleCount: 5,
      angle: 120,
      spread: 55,
      origin: { x: 1 },
    });

    if (Date.now() < end) {
      requestAnimationFrame(frame);
    }
  })();
}

function startWatch() {
  setInterval(tictac, 1000);
}

function tictac() {
  let actualDate = new Date();
  let hour = actualDate.getHours();
  let minute = actualDate.getMinutes();
  // get seconds and add a 0 if it's less than 10
  let second = String(actualDate.getSeconds()).padStart(2, "0");
  let clock = hour + ":" + minute + ":" + second;
  alarmText.textContent = clock;
}
