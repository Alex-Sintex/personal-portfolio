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
function validateFormUp(form) {
    // Extract stud_id from the form
    var stud_id = $(form).find("input[name='stud_id']").val();
    var usernameStud = $(form).find("#UpdateNctrStud" + stud_id).val();
    var NewPasswordStud = $(form).find("#UpdatePasswdStud" + stud_id).val();

    // Validation checks
    if (NewPasswordStud !== '') {
        var NewPasswdPattern = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;
        if (!NewPasswdPattern.test(NewPasswordStud)) {
            showError("La contraseña debe contener al menos un carácter especial");
            clearField("#UpdatePasswdStud" + stud_id); // Clear the incorrect field
            return;
        }
    }

    // If validation passes, create a FormData object for the AJAX request
    var formDataUp = new FormData();

    // Set the stud_id in the FormData
    formDataUp.append("stud_id", stud_id);
    formDataUp.append("UpdateNctrStud", usernameStud);
    formDataUp.append("UpdatePasswdStud", NewPasswordStud);

    return formDataUp;
}

// Call the previous function after validating form data before inserting it into the AJAX request
$("form[id^='updateStud']").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formDataUp = validateFormUp(this); // Pass the form as a parameter

    if (formDataUp) { // If validation passed and formData is not null
        var StudId = $(this).find("input[name='stud_id']").val(); // Get stud_id from the form

        // Proceed with the AJAX request
        $.ajax({
            type: "POST",
            url: "updateStudInfo",
            data: formDataUp,
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
                        if (result.message === "¡Ya hay un estudiante con ese número de control!") {
                            showError(result.message)
                            clearField("#UpdateNctrStud" + StudId); // Clear the incorrect field
                        }
                        break;
                    default:
                        // Handle AJAX error
                        showError(response); // Get the error message from the server
                        break;
                }
            }
        });
    }
});