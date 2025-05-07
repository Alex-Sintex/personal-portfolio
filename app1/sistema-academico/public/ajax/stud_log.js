$(document).ready(function () {

    $("#studForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var usernameStud = $("#usernameStud").val();
        var passwordStud = $("#passwordStud").val();

        // Check if fields are empty
        if (usernameStud === "" || passwordStud === "") {
            document.getElementById("usernameStud").classList.add("invalid");
            document.getElementById("passwordStud").classList.add("invalid");
            // Display SweetAlert for empty fields with a link
            Swal.fire({
                icon: 'warning',
                title: '¡Advertencia!',
                text: 'Asegúrese de proporcionar su número de control y la contraseña para ingresar',
                showConfirmButton: false
            });

            return; // Exit the function without submitting the form
        }

        // Prepare data for Ajax request
        var data = {
            usernameStud: usernameStud,
            passwordStud: passwordStud
        };

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "login/authStudent",
            data: data,
            dataType: "json", // Specify JSON as the expected response type
            success: function (response) {
                // Handle the response from the server
                if (response.status === "success") {
                    console.log(response);
                    // Handle successful login
                    var $this = $("#studForm");
                    var $myButton2 = $("#spinS");
                    var $state2 = $myButton2.find(".stateS");

                    // Add loading class and update the button state
                    $this.addClass("loadingS");
                    $state2.html("Autenticando, por favor espere...");

                    setTimeout(function () {
                        // Simulate a successful response from the server
                        $this.addClass("okS");
                        $state2.html(response.message);

                        // Disable the "Send" button
                        $("#spinS").prop("disabled", true);

                        setTimeout(function () {
                            $state2.html("Log in");
                            $this.removeClass("okS loadingS");
                        }, 4000);
                    }, 3000);
                    // Set a timer to delay the redirection
                    setTimeout(function () {
                        window.location.href = "https://localhost/sistema-academico/dashboard/student";
                    }, 5000); // Delay for 5 seconds (5000 milliseconds)
                } else if (response.message === "El nombre de usuario con ese número de control no existe") {
                    let timerInterval;
                    Swal.fire({
                        title: 'Error',
                        html: '<h2><b>' + response.message + '</b></h2>',
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
                            document.getElementById("usernameStud").classList.add("invalid");
                            document.getElementById("passwordStud").classList.add("invalid");
                            document.getElementById("usernameStud").value = '';
                            document.getElementById("passwordStud").value = '';
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            //console.log(response);
                        }
                    });
                } else if (response.message === "Contraseña incorrecta") {
                    let timerInterval;
                    Swal.fire({
                        title: 'Error',
                        html: '<h2><b>' + response.message + '</b></h2>',
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
                            document.getElementById("passwordStud").classList.add("invalid");
                            document.getElementById("usernameStud").classList.remove("invalid");
                            document.getElementById("passwordStud").value = '';
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log(response);
                        }
                    });
                } else {
                    let timerInterval;
                    Swal.fire({
                        title: 'Error',
                        html: '<h2><b>' + response.message + '</b></h2>',
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
                            // Reset the form
                            document.getElementById("usernameStud").classList.remove("invalid");
                            document.getElementById("passwordStud").classList.remove("invalid");
                            document.getElementById("studForm").reset();
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log(response);
                        }
                    });
                }
            }
        })

        // Prevent the form from submitting traditionally
        return false;
    });
});