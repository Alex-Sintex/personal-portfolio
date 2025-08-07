$(document).ready(function ($) {

    var originalValue = $('#EditnControlA').val();
    var $editControlA = $('#EditnControlA');

    $editControlA.on('input', function () {
        var currentValue = $editControlA.val();
        if (currentValue !== originalValue) {
            // Value has changed, revert to original value and make it readonly
            $editControlA.val(originalValue);
            $editControlA.prop('readonly', true);
        }
    });

    // Initialize the signature plugin
    var sig = $('#Editsig').signature({
        syncField: '#Editsignature64',
        syncFormat: 'PNG'
    });

    $('#Editclear').click(function (e) {
        e.preventDefault();
        sig.signature('clear');
        $("#Editsignature64").val('');
    });

    $("#EditfdcForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object to handle file upload
        var EditformData = new FormData();

        // Get header form data
        var EditfechaFDC = $("#EditfechaFDC").val();
        var EditasuntoA = $("#EditasuntoA").val();
        // Get body form data
        var EditnombreA = $("#EditnombreA").val();
        var EditaPaternoA = $("#EditaPaternoA").val();
        var EditaMaternoA = $("#EditaMaternoA").val();
        var EditcarreraA = $("input[name='EditcarreraA']").val();
        var EditnControlA = $("#EditnControlA").val();
        var EditpeticionA = $("#EditpeticionA").val();
        var EditmotivosAcaA = $("#EditmotivosAcaA").val();
        var EditmotivosPerA = $("#EditmotivosPerA").val();
        var EditotrosMA = $("#EditotrosMA").val();
        var EditfirmaA = sig.signature('toDataURL', 'image/png');
        var Editfirma = $('#Editsignature64').val();

        var EdittelefonoA = $("#EdittelefonoA").val();
        var EditcorreoA = $("#EditcorreoA").val();

        // Handle file uploads using the 'anexosA' input field
        var EditanexosA = $("input[name='EditanexosA[]']")[0].files;

        // Validation check for both fields motivos académicos and personales both cannot be emty
        if (!EditmotivosAcaA && !EditmotivosPerA) {
            // Ambos campos están vacíos
            $("#war2").append(
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
        for (var i = 0; i < EditanexosA.length; i++) {
            formData.append("EditanexosA[]", EditanexosA[i]);
            console.log(EditanexosA[i]);
        }

        // Create an array of form field values
        var formFields = [
            EditfechaFDC,
            EditasuntoA,
            EditnombreA,
            EditaPaternoA,
            EditaMaternoA,
            EditnControlA,
            EditpeticionA,
            //otrosMA,
            EdittelefonoA,
            EditcorreoA
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
        if (!Editfirma) {
            showError("Por favor, ingresa la firma");
            return;
        }

        // Validation check for asunto
        var topicPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (!topicPattern.test(EditasuntoA)) {
            showError("Por favor, ingresa únicamente palabras sin caracteres especiales");
            clearField("#EditasuntoA"); // Clear the incorrect field
            return;
        }

        // Check if the "date" field is empty
        if (!EditfechaFDC) {
            showError("Por favor, ingresa una fecha");
            clearField("#EditfechaFDC"); // Clear the incorrect field
            return;
        }

        // Updated name pattern to allow accented characters
        var namePattern = /^[a-zA-ZÀ-ÖØ-öø-ÿ ]+$/;

        // Validation check for name
        if (!namePattern.test(EditnombreA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#EditnombreA"); // Clear the incorrect field
            return;
        }

        if (!namePattern.test(EditaPaternoA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#EditaPaternoA"); // Clear the incorrect field
            return;
        }

        if (!namePattern.test(EditaMaternoA)) {
            showError("Por favor, ingresa un nombre válido");
            clearField("#EditaMaternoA"); // Clear the incorrect field
            return;
        }

        if (!EditcarreraA) {
            showError("Por favor, elija una carrera");
            return;
        }

        // Validation check for No. Control
        var noCtrlPattern = /^[a-zA-Z0-9]+$/;
        if (!noCtrlPattern.test(EditnControlA)) {
            showError("Por favor, ingrese un No. Control válido");
            clearField("#EditnControlA"); // Clear the incorrect field
            return;
        }

        // Validation check for asunto
        var subjPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (!subjPattern.test(EditpeticionA)) {
            showError("Por favor, ingresa una petición válida, sin caracteres especiales");
            clearField("#EditasuntoA"); // Clear the incorrect field
            return;
        }

        // Validation check for academic reasons
        var acadRPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (EditmotivosAcaA.trim() !== "" && !acadRPattern.test(EditmotivosAcaA)) {
            showError("Por favor, ingrese una razón académica válida, sin caracteres especiales");
            clearField("#EditmotivosAcaA"); // Clear the incorrect field
            return;
        }

        // Validation check for personal reasons
        var perRPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (EditmotivosPerA.trim() !== "" && !perRPattern.test(EditmotivosPerA)) {
            showError("Por favor, ingrese una razón personal válida, sin caracteres especiales");
            clearField("#EditmotivosPerA"); // Clear the incorrect field
            return;
        }

        // Validation check for other reasons
        var otherPattern = /^[^@[\]\/"'´<>\\|#$%()?¿!¡+{};¨^*]+$/;
        if (EditotrosMA.trim() !== "" && !otherPattern.test(EditotrosMA)) {
            showError("No se permiten caracteres especiales");
            clearField("#EditotrosMA"); // Clear the incorrect field
            return;
        }


        // Validation check for email
        var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
        if (!emailPattern.test(EditcorreoA)) {
            showError("Por favor, ingrese una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
            clearField("#EditcorreoA"); // Clear the incorrect field
            return;
        }

        // Prepare data for Ajax request
        EditformData.append("EditfechaFDC", EditfechaFDC);
        EditformData.append("EditasuntoA", EditasuntoA);
        EditformData.append("EditnombreA", EditnombreA);
        EditformData.append("EditaPaternoA", EditaPaternoA);
        EditformData.append("EditaMaternoA", EditaMaternoA);
        EditformData.append("EditcarreraA", EditcarreraA);
        EditformData.append("EditnControlA", EditnControlA);
        EditformData.append("EditpeticionA", EditpeticionA);
        EditformData.append("EditasuntoA", EditasuntoA);
        EditformData.append("EditmotivosAcaA", EditmotivosAcaA);
        EditformData.append("EditmotivosPerA", EditmotivosPerA);
        EditformData.append("EditotrosMA", EditotrosMA);
        EditformData.append("EditanexosA", EditanexosA);
        EditformData.append("EditfirmaA", EditfirmaA);
        EditformData.append("EdittelefonoA", EdittelefonoA);
        EditformData.append("EditcorreoA", EditcorreoA);

        // Send Ajax request to the server
        $.ajax({
            type: "POST",
            url: "editFDC",
            data: EditformData,
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