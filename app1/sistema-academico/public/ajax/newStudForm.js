$(document).ready(function () {
    $('.checkboxes__item input[type="checkbox"]').change(function () {
        $('.checkboxes__item input[type="checkbox"]').not(this).prop('checked', false);
    });
});

// Function to show errors to the user
function showError(message) {
    // Show SweetAlert error message
    let timerInterval;
    Swal.fire({
        title: 'Error',
        html: '<h2><b>' + message + '</b></h2>',
        icon: 'error',
        timer: 5000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
                // b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log(message);
        }
    });
}

// Function to clear data form values
function clearField(fieldSelector) {
    // Clear the input field by setting its value to an empty string
    $(fieldSelector).val('');
}

// Function to check data validation
function validateFormAdd() {

    // Get form data
    var nControl_stud = $("#nControl_stud").val();
    var password_stud = $("#password_stud").val();
    var stud_career = $("input[name='stud_career']").val();
    var stud_charge = $("input[name='stud_charge']").val();
    var stud_gender = $("input[name='stud_gender']:checked").val();

    // Create an array of form field values
    var formFields = [nControl_stud, password_stud];

    // Function to check if a value is empty
    function isEmpty(value) {
        return value.trim() === '';
    }

    // Iterate through the array and check for empty values
    for (var i = 0; i < formFields.length; i++) {
        if (isEmpty(formFields[i])) {
            // Display an error message
            showError("Por favor, llene los campos faltantes");
            // Stop further processing if an empty field is found
            return;
        }
    }

    // Validation checks
    if (!nControl_stud || !/^[0-9]{3}[A-Z][0-9]{5}$/.test(nControl_stud) || nControl_stud.length > 10) {
        showError("Sólo se permite ingresar 10 caracteres máximo y un número de control válido");
        clearField("#nControl_stud"); // Clear the incorrect field
        return;
    }

    if (!password_stud || !/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(password_stud)) {
        showError("La contraseña debe contener al menos un carácter especial");
        clearField("#password_stud"); // Clear the incorrect field
        return;
    }

    if (!stud_gender) {
        showError("Por favor, elija un género");
        return;
    }

    // If validation passes, create a FormData object for the AJAX request
    var formDataAdd = new FormData();
    formDataAdd.append("nControl_stud", nControl_stud);
    formDataAdd.append("password_stud", password_stud);
    formDataAdd.append("stud_career", stud_career);
    formDataAdd.append("stud_charge", stud_charge);
    formDataAdd.append("stud_gender", stud_gender);

    return formDataAdd; // Return the FormData object
}

// Call the previous function after validating format data before inserting to the AJAX request
$("#addStudForm").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formDataAdd = validateFormAdd(); // Get the FormData object

    if (formDataAdd) { // If validation passed and formData is not null
        // Proceed with the AJAX request
        $.ajax({
            type: "POST",
            url: "addNewStud",
            data: formDataAdd,
            contentType: false,
            processData: false,
            success: function (response) {
                var result = JSON.parse(response);
                // Handle the response from the server
                switch (result.status) {
                    case "success":
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: result.message,
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                location.reload(); // Refresh the current page on success
                            }
                        });
                        break;
                    case "error":
                        showError(result.message);
                        // Clear the username and email fields if needed
                        if (result.message === "El usuario ya existe con ese número de control") {
                            clearField("#nControl_stud");
                        }
                        break;
                    default:
                        // Handle other cases if needed
                        showError(result.message);
                        break;
                }
            }
        });
    }
});