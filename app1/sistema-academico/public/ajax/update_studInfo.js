$(document).ready(function () {

    /**
     * Handle data information section
     */
    $("#formRegisterStud").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object to handle file upload
        var formData = new FormData();

        // Get form data
        var stud_firstname = $("#stud_firstname").val();
        var stud_flastname = $("#stud_flastname").val();
        var stud_slastname = $("#stud_slastname").val();
        var stud_current_passwd = $("#stud_current_passwd").val();
        var stud_new_passwd = $("#stud_new_passwd").val();
        var stud_passwd_confirm = $("#stud_passwd_confirm").val();
        var stud_gender = $("input[name='stud_gender']:checked").val();

        if (!stud_current_passwd) {
            // Display an error message
            showError("Para realizar cambios en tu información debes introducir tu contraseña actual");
            // Stop further processing if an empty field is found
            return;
        }

        // Create an array of form field values
        var formFields = [stud_firstname, stud_flastname, stud_slastname];

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
        if (!namePattern.test(stud_firstname)) {
            showError("Por favor, introduzca un nombre válido, sin caracteres especiales");
            clearField("#stud_firstname"); // Clear the incorrect field
            return;
        }

        // Check if stud_new_passwd is not empty before performing the password pattern check
        if (stud_new_passwd.trim() !== "") {
            var passwdPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]).{8,}$/;

            // Check if the password pattern is not satisfied
            if (!passwdPattern.test(stud_new_passwd)) {
                showError("La contraseña debe cumplir con los requisitos de seguridad");
                clearField("#stud_new_passwd"); // Clear the incorrect field
                return;
            }
        }


        if (stud_new_passwd !== stud_passwd_confirm) {
            showError("Las contraseñas no coinciden");
            clearField("#stud_confirm_passwd"); // Clear the incorrect field
            return;
        }

        // Check if either of the radio buttons is selected
        if (!stud_gender) {
            showError("¡Por favor, seleccione un género!");
            return;
        }

        // Prepare data for Ajax request
        if (rawImg) {
            formData.append("image_data", rawImg);
            formData.append("filename", selectedFile.name);
            formData.append("file_type", selectedFile.type);
        }
        formData.append("stud_firstname", stud_firstname);
        formData.append("stud_flastname", stud_flastname);
        formData.append("stud_slastname", stud_slastname);
        formData.append("stud_current_passwd", stud_current_passwd);
        formData.append("stud_new_passwd", stud_new_passwd);
        formData.append("stud_gender", stud_gender);

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "account", // Controller URL
            data: formData, // FormData object for file upload
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Raw server response:", response); // Log the raw response
                var result = JSON.parse(response);
                // Handle the response from the server
                switch (result.status) {
                    // Use SweetAlert for success message
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
                        // Handle AJAX error
                        showError(result.message); // Get the error message from the server
                        if (result.message === "La contraseña actual es incorrecta") {
                            showError(result.message)
                            clearField("#stud_current_passwd"); // Clear the incorrect field
                        }
                        break;
                    default:
                        // Handle unexpected response
                        showError(response);
                        break;
                }
            }
        });
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

    /**
     * Image uploading section
     */
    var $uploadCrop, rawImg, selectedFile;

    function readFile(input) {
        if (input.files && input.files[0]) {
            selectedFile = input.files[0]; // Store the selected file
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            console.log("Sorry - your browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 160,
            height: 160,
            type: 'circle'
        },
        enforceBoundary: false,
        enableExif: true
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
        $('.cr-slider-wrap').prepend('<p>Image Zoom</p>');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log("Selected file", selectedFile);
        });
    });

    $('#cropImagePop').on('hidden.bs.modal', function () {
        $('.item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    // Check allowed file format
    $('.item-img').on('change', function () {
        // Check if the selected file is an image
        if (this.files && this.files[0]) {
            var fileType = this.files[0].type;
            if (!fileType.startsWith('image/') || (fileType !== 'image/png' && fileType !== 'image/jpeg')) {
                // Show a toast message indicating that image format is invalid
                iziToast.error({
                    title: 'Error',
                    message: 'Solo se permiten imagenes PNG/JPG',
                    position: 'topCenter'
                });
                return;
            }
            readFile(this);
        }
    });

    $(document).on('click', '.replacePhoto', function () {
        $('#cropImagePop').modal('hide');
        $('.item-img').trigger('click');
    });

    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            backgroundColor: "#000000",
            format: 'png',
            size: { width: 160, height: 160 }
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#cropImagePop').modal('hide');
            $('.item-img').val('');
        });
    });
});