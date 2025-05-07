// Function to show errors to the user
function showErrorUp(messageUp) {
    // Show SweetAlert error message
    let timerInterval;
    Swal.fire({
        title: 'Error',
        html: '<h2><b>' + messageUp + '</b></h2>',
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
            console.log(messageUp);
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

    // Extract userId from the form id
    var formId = $(form).attr('id');
    var userId = formId.replace('updateUser', ''); // Extract the numeric part of the formId

    var firstname = $("#UpdateName" + userId).val();
    var email = $("#UpdateEmail" + userId).val();
    var username = $("#UpdateUsername" + userId).val();
    var currentPassword = $("#currentPassword" + userId).val();
    var NewPassword = $("#NewPassword" + userId).val()

    // Validation checks
    if (!currentPassword) {
        showErrorUp("Por favor, introduzca la contraseña actual para aplicar los cambios");
        return;
    }

    var namePattern = /^[a-zA-Z ]+$/;
    if (!namePattern.test(firstname)) {
        showErrorUp("Por favor, introduzca un nombre válido que contenga sólo letras");
        clearField("#UpdateName" + userId); // Clear the incorrect field
        return;
    }

    var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
    if (!emailPattern.test(email)) {
        showErrorUp("Por favor, introduzca una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
        clearField("#UpdateEmail" + userId); // Clear the incorrect field
        return;
    }

    if (!username || username.length <= 6) {
        showErrorUp("El nombre de usuario debe contener un mínimo de 6 caracteres");
        clearField("#UpdateUsername" + userId); // Clear the incorrect field
        return;
    }

    // Check if NewPassword is not empty, then perform the special character check
    if (NewPassword !== '') {
        var NewPasswdPattern = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;
        if (!NewPasswdPattern.test(NewPassword)) {
            showErrorUp("La contraseña debe contener al menos un carácter especial");
            clearField("#NewPassword" + userId); // Clear the incorrect field
            return;
        }
    }

    // If validation passes, create a FormData object for the AJAX request
    var formDataUp = new FormData($(form)[0]);

    // Set the action parameter for the backend controller
    formDataUp.append("action", "updateUserInfo");
    formDataUp.append("user_id", userId);

    return formDataUp;
}

// Function to handle the form submission
function updateUserInfo(userId) {
    var modalId = "#editUser" + userId;

    // Find the form related to the modal
    var form = $(modalId).find('form');

    // Validate and submit the form
    var formDataUp = validateFormUp(form);

    if (formDataUp) {

        $.ajax({
            type: "POST",
            url: "updateUserInfo",
            data: formDataUp,
            contentType: false,
            processData: false,
            success: function (response) {

                try {
                    var result = JSON.parse(response);
                    //console.log("Raw server response:", response); // Log the raw response

                    switch (result.status) {
                        case "success":
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: result.message,
                                showConfirmButton: false,
                                timer: 1500,
                                didClose: () => {
                                    location.reload();
                                }
                            });
                            break;
                        case "error":
                            showErrorUp(result.message);
                            if (result.message === "La contraseña actual es incorrecta") {
                                showErrorUp(result.message);
                                clearField("#currentPassword" + userId);
                            }
                            break;
                        default:
                            showErrorUp(result.message);
                            break;
                    }
                } catch (error) {
                    // If there's an error parsing the JSON, log the entire response
                    console.error("Error parsing JSON response:", error);
                    showErrorUp(response);
                }
            },
            error: function (error) {
                console.error("Error in AJAX request:", error);
                showErrorUp("Error in AJAX request. Please try again later.");
            }
        });
    }
}

// Call the previous function after validating form data before inserting it into the AJAX request
$(document).ready(function () {
    // Use event delegation to handle submit event for the form
    $(document).on('submit', 'form[id^="updateUser"]', function (e) {
        e.preventDefault(); // Prevent the default form submission
    
        // Extract the user ID from the form ID
        var userId = $(this).attr('id').replace('updateUser', '');
    
        // Call the function to handle the update logic
        updateUserInfo(userId);
    
        // Return false to prevent further default behavior
        return false;
    });    

    // Use event delegation to handle click event for the "Edit" button
    $(document).on('click', '.btn-edit', function () {
        var userId = $(this).attr('id');
        var modalId = "#editUser" + userId;

        // Show the modal with the dynamically generated id
        $(modalId).modal('show');
    });
});