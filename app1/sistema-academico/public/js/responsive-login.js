let login = document.querySelector(".login");
//let signup = document.querySelector(".signup");
let student = document.querySelector(".student");

//let registerLink = document.querySelector('a[href="#reg"]');
//let loginLink = document.querySelector('a[href="#log"]');
let loginLink2 = document.querySelector('a[href="#log2"]');
let studentLink = document.querySelector('a[href="#stud"]');

let slider = document.querySelector(".slider");
let formSection = document.querySelector(".form-section");

loginLink2.addEventListener("click", (event) => {
    event.preventDefault();

    slider.classList.remove("movesliderStud");
    formSection.classList.remove("form-section-moveStud");
});

login.addEventListener("click", () => {
    slider.classList.remove("movesliderStud");
    formSection.classList.remove("form-section-moveStud");
});

// Student JS code
studentLink.addEventListener("click", (event) => {
    event.preventDefault();

    slider.classList.remove("movesliderLog");
    formSection.classList.remove("form-section-moveLog");
    formSection.classList.remove("form-sectionLog");

    slider.classList.add("movesliderStud");
    formSection.classList.add("form-section-moveStud");
});

student.addEventListener("click", () => {
    slider.classList.remove("movesliderLog");
    formSection.classList.remove("form-section-moveLog");
    formSection.classList.remove("form-sectionLog");

    slider.classList.add("movesliderStud");
    formSection.classList.add("form-section-moveStud");
});