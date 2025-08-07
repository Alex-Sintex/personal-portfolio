// Declare other function to pick another image in users/addUser view
const reader = new FileReader();
const fileInput = document.getElementById("file");
const img = document.getElementById("profile");
let file;

reader.onload = e => {
    img.src = e.target.result;
}

fileInput.addEventListener('change', e => {
    const f = e.target.files[0];
    file = f;
    reader.readAsDataURL(f);
})

// Display file name in addUser modal
function display_image_nameA(file_name) {
    document.querySelector('.file_info').innerHTML = '<b>Selected file:</b><br>' + file_name;
}