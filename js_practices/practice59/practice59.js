let text1 = document.getElementById("mytext");

function verify_number(event) {
  if (event.keyCode < 48 || event.keyCode > 57) {
    event.preventDefault();
  }
}

// keydown event is triggered when a key is pressed
text1.addEventListener("keydown", verify_number);

// keyup event is triggered when a key is released
text1.addEventListener("keyup", function (event) {
  console.log("User input" + event.target.value);
});

// keypress event is triggered when a key is pressed
text1.addEventListener("keypress", function (event) {
  console.log("Character entered: " + event.key);
});
