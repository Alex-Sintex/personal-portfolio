$(document).ready(function () {

    $("#loginForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var username = $("#username").val();
        var password = $("#password").val();

        // Check if fields are empty
        if (username === "" || password === "") {
            document.getElementById("username").classList.add("invalid");
            document.getElementById("password").classList.add("invalid");
            // Display SweetAlert for empty fields with a link
            Swal.fire({
                icon: 'warning',
                title: '¡Advertencia!',
                text: 'Haga clic en el enlace de abajo para más información',
                showConfirmButton: false,
                footer: '<a href="#" id="showMoreInfo">¿Por qué se muestra este mensaje?</a>'
            });

            // Add a click event listener to the link
            $("#showMoreInfo").click(function (e) {
                e.preventDefault();

                // Show another SweetAlert message when the link is clicked
                Swal.fire({
                    icon: 'info',
                    title: 'Más información',
                    text: 'Asegúrese de proporcionar un nombre de usuario y una contraseña para ingresar',
                });
            });

            return; // Exit the function without submitting the form
        }

        // Prepare data for Ajax request
        var data = {
            username: username,
            password: password,
            remember: $("#remember").prop("checked") ? "on" : "off"
        };

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "login/login",
            data: data,
            dataType: "json", // Specify JSON as the expected response type
            success: function (response) {
                // Handle the response from the server
                if (response.status === "success") {
                    // Handle successful login
                    var $this = $("#loginForm");
                    var $myButton = $("#spin");
                    var $state = $myButton.find(".state");

                    // Add loading class and update the button state
                    $this.addClass("loading");
                    $state.html("Autenticando, por favor espere...");

                    // Simulate a successful response from the server
                    setTimeout(function () {
                        $this.addClass("ok");
                        $state.html(response.message);
                    }, 2500);

                    // Reload the current page after 5000 milliseconds (5 seconds)
                    setTimeout(function () {
                        // Reload the current page
                        window.location.reload();
                    }, 3000);
                } else if (response.message === "El nombre de usuario no existe") {
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
                            document.getElementById("username").classList.add("invalid");
                            document.getElementById("password").classList.add("invalid");
                            document.getElementById("username").value = '';
                            document.getElementById("password").value = '';
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
                            document.getElementById("password").classList.add("invalid");
                            document.getElementById("username").classList.remove("invalid");
                            document.getElementById("password").value = '';
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
                            document.getElementById("username").classList.remove("invalid");
                            document.getElementById("password").classList.remove("invalid");
                            document.getElementById("loginForm").reset();
                        }
                    });
                }
            }
        })

        // Prevent the form from submitting traditionally
        return false;
    });
});