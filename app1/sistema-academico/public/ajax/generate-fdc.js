$(document).ready(function ($) {

    // Custom JS Signature
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });

    $('#clear').click(function (e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });

    $("#fdcForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object to handle file upload
        var formData = new FormData();

        // Get header form data
        var fechaFDC = $("#fechaFDC").val();
        var asuntoA = $("#asuntoA").val();
        // Get body form data
        var nombreA = $("#nombreA").val();
        var aPaternoA = $("#aPaternoA").val();
        var aMaternoA = $("#aMaternoA").val();
        var carreraA = $("input[name='carreraA']").val();
        var nControlA = $("#nControlA").val();
        var peticionA = $("#peticionA").val();
        var motivosAcaA = $("#motivosAcaA").val();
        var motivosPerA = $("#motivosPerA").val();
        var otrosMA = $("#otrosMA").val();
        var firmaA = $('#sig').signature('toDataURL', 'image/png');
        var firma = $('#signature64').val();

        var telefonoA = $("#telefonoA").val();
        var correoA = $("#correoA").val();

        // Handle file uploads using the 'anexosA' input field
        var anexosA = $("input[name='anexosA[]']")[0].files;

        // Validation check for both fields motivos académicos and personales both cannot be emty
        if (!motivosAcaA && !motivosPerA) {
            // Ambos campos están vacíos
            $("#war1").append(
                '<div class="alert callout alert-warning alert-dismissible">' +
                '  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                '  <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Advertencia!</h4>' +
                '  ¡Se debe llenar el campo de <b>motivos académicos</b> en caso que exista uno o <b>motivos personales</b>, en caso contrario dejar vacío únicamente uno de los 2 campos!' +
                '</div>'
            );
            // Display an error message
            showError("No se pueden dejar los 2 campos vacíos, se debe llenar al menos un campo, académicos o personales");
            // Stop further processing if an empty field is found
            return;
        }

        // Iterate through the files and append them to the FormData
        for (var i = 0; i < anexosA.length; i++) {
            formData.append("anexosA[]", anexosA[i]);
            console.log(anexosA[i]);
        }

        // Create an array of form field values
        var formFields = [
            fechaFDC,
            asuntoA,
            nombreA,
            aPaternoA,
            aMaternoA,
            nControlA,
            peticionA,
            //otrosMA,
            telefonoA,
            correoA
        ];

        // Function to check if a value is empty
        function isEmpty(value) {
            return value.trim() === '';
        }

        // Iterate through the array and check for empty values
        for (var i = 0; i < formFields.length; i++) {
            if (isEmpty(formFields[i])) {
                // Display an error message
                showError("Hay campos vacíos, asegurate de completar los campos requeridos");
                // Stop further processing if an empty field is found
                return;
            }
        }

        // Validation check for signature
        if (!firma) {
            showError("Por favor, ingresa la firma");
            return;
        }

        // Validation check for asunto
        var topicPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (!topicPattern.test(asuntoA)) {
            showError("Por favor, ingresa únicamente palabras sin caracteres especiales");
            clearField("#asuntoA"); // Clear the incorrect field
            return;
        }

        // Check if the "date" field is empty
        if (!fechaFDC) {
            showError("Por favor, ingresa una fecha");
            clearField("#fechaFDC"); // Clear the incorrect field
            return;
        }

        // Updated name pattern to allow accented characters
        var namePattern = /^[a-zA-ZÀ-ÖØ-öø-ÿ ]+$/;

        // Validation check for name
        if (!namePattern.test(nombreA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#nombreA"); // Clear the incorrect field
            return;
        }

        if (!namePattern.test(aPaternoA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#aPaternoA"); // Clear the incorrect field
            return;
        }

        if (!namePattern.test(aMaternoA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#aMaternoA"); // Clear the incorrect field
            return;
        }

        if (!carreraA) {
            showError("Por favor, elija una carrera");
            return;
        }

        // Validation check for No. Control
        var noCtrlPattern = /^[a-zA-Z0-9]+$/;
        if (!noCtrlPattern.test(nControlA)) {
            showError("Por favor, ingrese un No. Control válido");
            clearField("#nControlA"); // Clear the incorrect field
            return;
        }

        // Validation check for asunto
        var subjPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (!subjPattern.test(peticionA)) {
            showError("Por favor, ingresa una petición válida, sin caracteres especiales");
            clearField("#asuntoA"); // Clear the incorrect field
            return;
        }

        // Validation check for academic reasons
        var acadRPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (motivosAcaA.trim() !== "" && !acadRPattern.test(motivosAcaA)) {
            showError("Por favor, ingrese una razón académica válida, sin caracteres especiales");
            clearField("#motivosAcaA"); // Clear the incorrect field
            return;
        }

        // Validation check for personal reasons
        var perRPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (motivosPerA.trim() !== "" && !perRPattern.test(motivosPerA)) {
            showError("Por favor, ingrese una razón personal válida, sin caracteres especiales");
            clearField("#motivosPerA"); // Clear the incorrect field
            return;
        }

        // Validation check for other reasons
        var otherPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (otrosMA.trim() !== "" && !otherPattern.test(otrosMA)) {
            showError("No se permiten caracteres especiales");
            clearField("#otrosMA"); // Clear the incorrect field
            return;
        }

        // Validation check for email
        var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
        if (!emailPattern.test(correoA)) {
            showError("Por favor, ingrese una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
            clearField("#correoA"); // Clear the incorrect field
            return;
        }

        // Prepare data for Ajax request
        formData.append("fechaFDC", fechaFDC);
        formData.append("asuntoA", asuntoA);
        formData.append("nombreA", nombreA);
        formData.append("aPaternoA", aPaternoA);
        formData.append("aMaternoA", aMaternoA);
        formData.append("carreraA", carreraA);
        formData.append("nControlA", nControlA);
        formData.append("peticionA", peticionA);
        formData.append("asuntoA", asuntoA);
        formData.append("motivosAcaA", motivosAcaA);
        formData.append("motivosPerA", motivosPerA);
        formData.append("otrosMA", otrosMA);
        formData.append("anexosA", anexosA);
        formData.append("firmaA", firmaA);
        formData.append("telefonoA", telefonoA);
        formData.append("correoA", correoA);

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "createFDC",
            data: formData,
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
                                location.reload();
                            }
                        });
                        break;
                    case "error":
                        showError(result.message);
                        break;
                    default:
                        // Handle AJAX error
                        showError(response); // Get the error message from the server
                        break;
                }
            }
        })
    });

    function showError(message) {
        // Show SweetAlert error message
        let timerInterval;
        Swal.fire({
            title: 'Warning',
            html: '<h2><b>' + message + '</b></h2>',
            icon: 'warning',
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