$(document).ready(function () {
    $("#forgotPasswd").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Declare a local variable for email value
        var email = $("#recovery_email").val();

        // Validation check for email
        if (email === "") {
            document.getElementById("recovery_email").classList.add("invalid");
            // Display SweetAlert for empty field
            Swal.fire({
                icon: 'warning',
                title: 'Alerta',
                text: '¡Se requiere ingresar un correo electrónico para restablecer la contraseña!'
            });
            return;
        }

        var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
        if (!emailPattern.test(email)) {
            document.getElementById("recovery_email").classList.add("invalid");
            showError("Por favor, introduzca una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
            clearField("#recovery_email"); // Clear the incorrect field
            return;
        }

        // Prepare data for Ajax request
        var formData = {
            recovery_email: email
        };

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "login/generatePasswordResetToken", // Controller URL
            data: formData, // Use FormData object for file upload
            success: function (response) {
                // Handle the response from the server
                if (response === "Las instrucciones para restablecer su contraseña fueron enviadas a su correo") {
                    document.getElementById("recovery_email").classList.remove("invalid");
                    // Clear the email input
                    clearField("#recovery_email");
                    // Close the modal
                    $('#forgotPasswd').modal('hide');
                    // Use SweetAlert for success message
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else if (response === "El correo electrónico proporcionado no corresponde a una cuenta") {
                    let timerInterval;
                    Swal.fire({
                        title: 'Error',
                        html: '<h2><b>' + response + '</b></h2>',
                        icon: 'error',
                        timer: 3000,
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
                        },
                        didClose: () => {
                            // Clear the email input
                            clearField("#recovery_email");
                            document.getElementById("recovery_email").classList.add("invalid");
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log(response);
                        }
                    });
                } else {
                    document.getElementById("recovery_email").classList.add("invalid");
                    // Handle AJAX error
                    showError(response); // Get the error message from the server
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
