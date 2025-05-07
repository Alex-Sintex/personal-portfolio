// Function to show errors to the user
function showErrorAdd(messageAdd) {
    // Show SweetAlert error message
    let timerInterval;
    Swal.fire({
        title: 'Error',
        html: '<h2><b>' + messageAdd + '</b></h2>',
        icon: 'error',
        timer: 5000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => { }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log(messageAdd);
        }
    });
}

// Function to clear form field values
function clearField(fieldSelector) {
    $(fieldSelector).val('');
}

// Function to check data validation
function validateFormAdd() {
    // Get form data
    var firstname = $("#firstname").val();
    var email = $("#email").val();
    var username = $("#username").val();
    var password = $("#password").val();
    var charge = $("input[name='charge']").val();
    var career = $("input[name='career']").val();
    var selectedGender = $("input[name='gender']:checked").val();

    // Array of form fields
    var formFields = [firstname, email, username, password];

    // Check if a field is empty
    function isEmpty(value) {
        return value.trim() === '';
    }

    for (var i = 0; i < formFields.length; i++) {
        if (isEmpty(formFields[i])) {
            showErrorAdd("Por favor, llene los campos faltantes");
            return null; // Stop further processing if validation fails
        }
    }

    // Validation for specific fields
    var namePattern = /^[a-zA-Z ]+$/;
    if (!namePattern.test(firstname)) {
        showErrorAdd("Por favor, introduzca un nombre válido que contenga sólo letras");
        clearField("#firstname");
        return null;
    }

    var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
    if (!emailPattern.test(email)) {
        showErrorAdd("Por favor, introduzca una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
        clearField("#email");
        return null;
    }

    if (username.length <= 6) {
        showErrorAdd("El nombre de usuario debe contener un mínimo de 6 caracteres");
        clearField("#username");
        return null;
    }

    if (!password || !/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(password)) {
        showErrorAdd("La contraseña debe contener al menos un carácter especial");
        clearField("#password");
        return null;
    }

    if (!charge) {
        showErrorAdd("Por favor, elija un cargo");
        return null;
    }

    if (!selectedGender) {
        showErrorAdd("¡Por favor, seleccione un género!");
        return null;
    }

    // Create a FormData object if validation passes
    var formDataAdd = new FormData();
    formDataAdd.append("firstname", firstname);
    formDataAdd.append("email", email);
    formDataAdd.append("username", username);
    formDataAdd.append("password", password);
    formDataAdd.append("charge", charge);
    formDataAdd.append("career", career);
    formDataAdd.append("gender", selectedGender);

    return formDataAdd; // Return the FormData object
}

// Submit event handler for form
$('#newUserForm').on('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formDataAdd = validateFormAdd(); // Get the FormData object

    if (formDataAdd) { // If validation passed and formData is not null
        $.ajax({
            type: "POST",
            url: "addNewUser",  // Script to add user
            data: formDataAdd,      // FormData object with user data
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    var result = JSON.parse(response);
                    //console.log("Raw server response:", response); // Log the raw response

                    if (result.status === "error") {
                        // Display the error message to the user
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.message,
                        });
                    } else if (result.status === "success") {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: result.message,
                        });

                        // Append the new record to the table
                        var newRow = `<tr class="new-user-row" style="display: none;">
                                        <td>${result.user.id}</td>
                                        <td>${result.user.firstname}</td>
                                        <td>${result.user.email}</td>
                                        <td>${result.user.username}</td>
                                        <td>${result.user.charge}</td>
                                        <td>
                                            <a style="display: inline; padding: 0px 10px;" class="btn btn-warning btn-edit" id="${result.user.id}">Editar</a>
                                            <a style="display: inline; padding: 0px 10px;" class="btn btn-danger btn-delete" id="${result.user.id}">Eliminar</a>
                                        </td>
                                    </tr>`;

                        // Append the new row with fade-in effect
                        $('#example tbody').append(newRow);
                        $('.new-user-row').fadeIn(1000);  // Animate the appearance of the new row

                        // Optionally, clear form fields after successful submission
                        $('#newUserForm')[0].reset();
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.',
                    });
                }
            },
            error: function (error) {
                console.error("AJAX request error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.',
                });
            }
        });
    }
});