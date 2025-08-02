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
function validateFormReset() {
    // Get form data
    var new_password = $("#new_password").val();
    var confirm_passwd = $("#confirm_passwd").val();
    var token = $("#token").val(); // Get the token from the form

    // Function to check if a value is empty
    function isEmpty(value) {
        return value.trim() === '';
    }

    // Usage
    if (isEmpty(new_password)) {
        // Display an error message
        showError("Ingresa una nueva contraseña");
        // Stop further processing if an empty field is found
        return null; // Return null to indicate validation failure
    }

    if (!new_password || !/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(new_password)) {
        showError("La contraseña debe contener al menos un carácter especial");
        clearField("#new_password"); // Clear the incorrect field
        return null; // Return null to indicate validation failure
    }

    if (new_password !== confirm_passwd) {
        showError("Las contraseñas no coinciden");
        clearField("#confirm_passwd"); // Clear the incorrect field
        return null; // Return null to indicate validation failure
    }

    // Prepare data for Ajax request
    var data = {
        new_password: new_password,
        token: token
    };

    return data; // Return the FormData object
}

// Call the previous function after validating format data before inserting to the AJAX request
$("#recovery").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    var FormDataReset = validateFormReset(); // Get the FormData object

    if (FormDataReset) { // If validation passed and formData is not null
        // Proceed with the AJAX request
        $.ajax({
            type: "POST",
            url: "recovery",
            data: FormDataReset,
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
                                // Reset the form
                                document.getElementById("recovery").reset();
                            }
                        });
                        // Set a timer to delay the redirection
                        setTimeout(function () {
                            window.location.href = "https://localhost/sistema-academico";
                        }, 2000); // Delay for 2 seconds (2000 milliseconds)
                        break;
                    case "error":
                        showError(result.message);
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