$(document).ready(function ($) {

    // Show acta modal
    $("#ModalActa").iziModal({ // Initialize iziModal
        transitionIn: 'bounceInDown',
        transitionOut: 'bounceOutDown',
        transitionInOverlay: 'fadeIn',
        transitionOutOverlay: 'fadeOut',
        radius: 5,
        padding: 20,
        openFullscreen: true,
        width: 1000,
        closeButton: true,
        title: "ACTA DEL COMITÉ ACADÉMICO",
        headerColor: "#367fa9",
        bodyOverflow: true,
        fullscreen: true, // Set fullscreen option to true
        onOpening: function (modal) {
            // Bind click event to fetch button
            $("#save_changes").on("click", function (event) {
                event.preventDefault(); // Prevent the default form submission
                submitData(modal);
            });
        }
    });
});

// Function to show errors to the user
function showError(message) {
    iziToast.error({
        title: 'Error',
        position: "topCenter",
        icon: 'fa fa-exclamation-triangle',
        transitionIn: 'fadeInUp',
        transitionOut: 'fadeOut',
        transitionInMobile: 'fadeInUp',
        transitionOutMobile: 'fadeOutDown',
        message: message,
        timeout: 5000
    });
}

// Function to clear data form values
function clearField(fieldSelector) {
    // Clear the input field by setting its value to an empty string
    $(fieldSelector).val('');
}

// Function to check data validation
function validateFormData() {
    // Create a FormData object to handle file upload
    var formData = new FormData();

    // Get header form data
    var nameSesActa = $("#nameSesActa").val();
    var celebrated_at = $("#celebrated_at").val();
    var timeActa = $("#acta_time").val();
    var fechaActa = $("#acta_date").val();
    var noMembers = $("#NoMembers").val();

    // Get header guest info
    var guest_fname = $("#guest_fname").val();
    var guest_charge = $("#guest_charge").val();

    // Get body form data
    var folio = $("#folio").val();
    var asunto = $("#asunto").val();
    var resolucion = $("#resolucion").val();
    var full_name = $("#nomAlum").val();
    var nCtrlAlum = $("#nCtrlAlum").val();
    var recomendacion = $("#recomendacion").val();

    // Get general requests
    var resolucionAG = $("#resolucionAG").val();
    var nomAlumAG = $("#nomAlumAG").val();
    var nCtrlAlumAG = $("#nCtrlAlumAG").val();
    var careerSelAG = $("#careerSelAG").val();
    var responsableAG = $("#responsableAG").val();

    /* Validation fields */
    // Updated name pattern to allow accented characters
    var namePattern = /^[a-zA-ZÀ-ÖØ-öø-ÿ ]+$/;

    // Validation check for full name
    if (guest_fname !== '') {
        if (!namePattern.test(guest_fname)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#guest_fname"); // Clear the incorrect field
            return;
        }
    }

    // Validation check for guest charge
    if (guest_charge !== '') {
        if (!namePattern.test(guest_charge)) {
            showError("Por favor, ingresa un cargo válido");
            clearField("#guest_charge"); // Clear the incorrect field
            return;
        }
    }

    // Append other values to form
    var checkFields = [
        celebrated_at,
        timeActa,
        fechaActa,
        noMembers
    ];

    // Function to check if a value is empty
    function isEmpty(value) {
        return value.trim() === '';
    }

    // Iterate through the array and check for empty values
    for (var i = 0; i < checkFields.length; i++) {
        if (isEmpty(checkFields[i])) {
            // Display an error message
            showError("Hay campos vacíos, asegurate de completar los campos requeridos");
            // Stop further processing if an empty field is found
            return;
        }
    }

    // Validate noMembers range
    if (isNaN(noMembers) || noMembers < 1 || noMembers > 17) {
        showError('Por favor, introduzca un valor entre 1 y 17');
        clearField("#NoMembers"); // Clear the incorrect field
        return;
    }

    // Validate folio input
    if (!isValidFolioFormat(folio)) {
        showError('Por favor, introduzca un número de folio válido en el formato correcto (por ejemplo, 001/2023)');
        clearField("#folio"); // Clear the incorrect field
        return;
    }

    // Function to check if a value is a valid folio format (e.g., 001/2023)
    function isValidFolioFormat(value) {
        // Checks for three digits followed by a '/', and then four digits.
        var folioPattern = /^\d{3}\/\d{4}$/;

        // Test if the value matches the pattern
        return folioPattern.test(value);
    }

    if (!namePattern.test(asunto)) {
        showError("Por favor, introduce un asunto válido");
        clearField("#asunto");
        return;
    }

    if (!namePattern.test(resolucion)) {
        showError("Por favor, introduce una resolución válida");
        clearField("#resolucion");
        return;
    }

    if (!namePattern.test(full_name)) {
        showError("Por favor, introduce un nombre válido");
        clearField("#nomAlum");
        return;
    }

    if (!namePattern.test(recomendacion)) {
        showError("Por favor, introduce una recomendación válida");
        clearField("#recomendacion");
        return;
    }

    // General requests validation
    if (!namePattern.test(resolucionAG)) {
        showError("Por favor, introduce una resolución válida");
        clearField("#resolucionAG");
        return;
    }

    if (!namePattern.test(nomAlumAG)) {
        showError("Por favor, introduce un nombre completo válido");
        clearField("#nomAlumAG");
        return;
    }

    if (!namePattern.test(responsableAG)) {
        showError("Por favor, introduce un nombre válido");
        clearField("#responsableAG");
        return;
    }

    // Prepare data for Ajax request
    formData.append("folio", folio);
    formData.append("asunto", asunto);
    formData.append("resolucion", resolucion);
    formData.append("full_name", full_name);
    formData.append("nCtrlAlum", nCtrlAlum);
    formData.append("recomendacion", recomendacion);
    formData.append("nameSesActa", nameSesActa);
    formData.append("celebrated_at", celebrated_at);
    formData.append("acta_time", timeActa);
    formData.append("acta_date", fechaActa);
    formData.append("NoMembers", noMembers);
    // General requests form append data
    formData.append("resolucionAG", resolucionAG);
    formData.append("nomAlumAG", nomAlumAG);
    formData.append("nCtrlAlumAG", nCtrlAlumAG);
    formData.append("careerSelAG", careerSelAG);
    formData.append("responsableAG", responsableAG);

    // Check for values if empty first before appending
    if (guest_fname !== '' && guest_charge !== '') {
        formData.append("guest_fname", guest_fname);
        formData.append("guest_charge", guest_charge);
    }

    return formData; // Return the FormData object
}

function submitData(modal) {

    // Get the FormData object
    var formData = validateFormData();

    // If validation passed and formData is not null
    if (formData) {
        // Start loading form animation
        modal.startLoading();
        // Proceed with the AJAX request
        $.ajax({
            type: "POST",
            url: "infoActa",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Raw server response:", response); // Log the raw response
                var result = JSON.parse(response);
                // Handle the response from the server
                switch (result.status) {
                    case "success":
                        iziToast.success({
                            title: 'Success',
                            position: "topCenter",
                            icon: 'fa fa-check',
                            transitionIn: 'fadeInUp',
                            transitionOut: 'fadeOut',
                            transitionInMobile: 'fadeInUp',
                            transitionOutMobile: 'fadeOutDown',
                            message: result.message,
                            timeout: 5000
                        });

                        // Reset the form after successful submission
                        $('#ActaForm')[0].reset();

                        break;
                    case "error":
                        showError(result.message);
                        // Stop loading regardless of success or failure
                        break;
                    default:
                        // Handle AJAX error
                        showError(response); // Get the error message from the server
                        break;
                }
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
                // Stop loading regardless of success or failure
                modal.stopLoading();
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var optionalIn = document.querySelectorAll('.optional');
    optionalIn.forEach(function (input) {
        input.style.display = 'none';
    });
});

function toggleInputs() {
    var optionalIn = document.querySelectorAll('.optional');
    optionalIn.forEach(function (input) {
        if (input.style.display === 'none') {
            input.style.display = 'inline-block';
            input.style.opacity = 1;
        } else {
            input.style.display = 'none';
            input.style.opacity = 0;
        }
    });

    var button = document.querySelector('.btn-default');
    button.classList.toggle('btn-clicked');

    setTimeout(function () {
        button.classList.toggle('btn-clicked');
    }, 500);
}