let selector = document.getElementById("mySelector");
let input = document.getElementById("myInput");
let btn = document.getElementById("myBtn");
let list = document.getElementById("myList");
let div = document.getElementById("res");
div.style.display = "none";

let file = "peliculas.json";

selector.addEventListener("change", changeFile);
selector.addEventListener("changeMode", messageMode);
input.addEventListener("keydown", verifyInput);
btn.addEventListener("click", search);

/**
 * Changes the value of the file variable based on the value of the selector element.
 * Triggers a custom event named "changeMode".
 * Dispatches the event.
 */
function changeFile() {
  file = selector.value;
  let event = new CustomEvent("changeMode");
  selector.dispatchEvent(event);
}

/**
 * Displays a message with the matching search file name.
 * Triggered by a change in the value of the selector element.
 * @fires CustomEvent#changeMode
 */
function messageMode() {
  swal.fire("The matching search file is: " + selector.value);
}

/**
 * Prevents the user from typing any character other than a letter, space, or backspace.
 * @param {Event} event - The event object.
 */
function verifyInput(event) {
  if (
    (event.keyCode < 65 || event.keyCode > 90) &&
    event.keyCode != 32 &&
    event.keyCode != 8
  ) {
    event.preventDefault();
  }
}

/**
 * Clears the list and populates it with items from the selected file.
 * Each item is a list element with the name of the item and a hidden paragraph with its synopsis.
 * When the user hovers over an item, its synopsis is displayed.
 * When the user hovers out of an item, its synopsis is hidden.
 */
function search() {
  // Clear the list
  list.innerHTML = "";
  div.style.display = "block";
  let found = false;

  // Check if the input is empty
  if (!input.value.trim()) {
    swal.fire("El campo está vacío");
    div.style.display = "none";
    return;
  }

  fetch(file)
    .then((response) => response.json())
    .then(function (output) {
      for (let item of output.data) {
        if (item.nombre.startsWith(input.value.toUpperCase())) {
          let p = document.createElement("p");
          p.id = item.nombre;
          p.innerHTML = item.sinopsis;
          p.style.display = "none";

          let li = document.createElement("li");
          li.innerHTML = item.nombre;
          li.addEventListener("mouseover", function () {
            let p = document.getElementById(item.nombre);
            p.style.display = "block";
          });
          li.addEventListener("mouseout", function () {
            let p = document.getElementById(item.nombre);
            p.style.display = "none";
          });
          li.appendChild(p);
          list.appendChild(li);
          found = true;
        }
      }

      // If no matches are found display a message
      if (!found) {
        let p = document.createElement("p");
        p.textContent = "No se encontraron coincidencias";
        list.appendChild(p);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
}
