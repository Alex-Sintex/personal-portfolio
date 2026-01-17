let btn = document.getElementById("btn1");

function message() {
  alert("I am a mousover");
}

function showMessage() {
  alert("Button pressed!");
}

// Event listener
btn.addEventListener("mouseover", message);
btn.addEventListener("click", showMessage);
