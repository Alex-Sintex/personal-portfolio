let btn = document.getElementById("btn1");
let div = document.getElementById("div1");
let link = document.getElementById("link1");

function block_link(evt) {
  evt.preventDefault();
  alert("Link is not available");
}

function showMessage(event) {
  // Target = button
  alert(event.target);
  // Current target = div
  alert(event.currentTarget);
}

div.addEventListener("click", showMessage);
link.addEventListener("click", block_link);