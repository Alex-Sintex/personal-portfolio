document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.querySelector(".input-group i.fas.fa-eye");

    toggleIcon.onclick = () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.add("active");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("active");
        }
    };
});

document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("passwordStud");
    const toggleIcon = document.querySelector(".input-group #stud_showP");

    toggleIcon.onclick = () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.add("active");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("active");
        }
    };
});