$(document).ready(function () {

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    $("#formRegister").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object to handle file upload
        var formData = new FormData();
        formData.append("profile_image", $("input[name='profile_image']")[0].files[0]);

        // Get form data
        var name = $("#firstname").val();
        var email = $("#email").val();
        var username = $("#usernameReg").val();
        var password = $("#passwordReg").val();
        var confirm_passwd = $("#confirm_passwd").val();
        var selectedGender = $("input[name='gender']:checked").val();
        var charge = $("input[name='charge']").val();
        var career = $("input[name='career']").val();
        var acceptTerms = $("#acceptTerms").is(":checked");

        // Create an array of form field values
        var formFields = [name, email, username, password, confirm_passwd];

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
        var namePattern = /^[a-zA-Z ]+$/;
        if (!namePattern.test(name)) {
            showError("Por favor, introduzca un nombre válido, sin caracteres especiales");
            clearField("#firstname"); // Clear the incorrect field
            return;
        }

        // Validation check for email
        var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
        if (!emailPattern.test(email)) {
            showError("Por favor, introduzca una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
            clearField("#email"); // Clear the incorrect field
            return;
        }

        if (!username || username.length <= 6) {
            showError("El nombre de usuario debe contener un mínimo de 6 caracteres");
            clearField("#usernameReg"); // Clear the incorrect field
            return;
        }

        if (!password || !/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/.test(password)) {
            showError("La contraseña debe contener al menos un carácter especial");
            clearField("#passwordReg"); // Clear the incorrect field
            return;
        }

        if (password !== confirm_passwd) {
            showError("Las contraseñas no coinciden");
            clearField("#confirm_passwd"); // Clear the incorrect field
            return;
        }

        // Check if either of the radio buttons is selected
        if (!selectedGender) {
            showError("¡Por favor, seleccione un género!");
            return;
        }

        if (!charge) {
            showError("¡Por favor, elija un cargo!");
            return;
        }

        if (!acceptTerms) {
            showError("¡Debes aceptar los términos y condiciones!");
            return;
        }

        // Prepare data for Ajax request
        formData.append("firstname", name);
        formData.append("email", email);
        formData.append("usernameReg", username);
        formData.append("passwordReg", password);
        formData.append("gender", selectedGender);
        formData.append("charge", charge);
        formData.append("career", career);

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "login/register", // Controller URL
            data: formData, // Use FormData object for file upload
            contentType: false, // Set contentType to false when using FormData
            processData: false, // Set processData to false when using FormData
            success: function (response) {
                // Handle the response from the server
                if (response === "Cuenta creada correctamente") {
                    // Use SweetAlert for success message
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Set a timer to delay the redirection
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000); // Delay for 2 seconds (2000 milliseconds)
                } else {
                    // Handle AJAX error
                    showError(response); // Get the error message from the server
                    // Clear the username and email fields if they already exist
                    if (response === "Ya hay un usuario con ese nombre") {
                        clearField("#username");
                    } else if (response === "Ya existe un usuario con ese correo") {
                        clearField("#email");
                    }
                }
            }
        })
    });

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
    function clearField(fieldSelector) {
        // Clear the input field by setting its value to an empty string
        $(fieldSelector).val('');
    }
});
