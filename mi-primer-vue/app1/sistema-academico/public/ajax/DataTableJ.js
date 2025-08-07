// Table 3: example 3
$(document).ready(function () {
    // Initialize DataTable
    var table1 = $('#example3').DataTable({
        autoWidth: false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                download: 'open', filename: function () {
                    return "F-DC-15 Tabla"
                },
                title: function () {
                    var searchString = table1.search();
                    return searchString.length ? "Search: " + searchString : "Solicitudes F-DC-15"
                }
            }, 'colvis'],
        columns: [
            {
                title: 'No. Control',
                width: '',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'nControl');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'nControl'
            },
            {
                title: 'Nombre',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'name');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'nombre'
            },
            {
                title: 'Apellido Paterno',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'aPaterno');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'aPaterno'
            },
            {
                title: 'Apellido Materno',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'aMaterno');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'aMaterno'
            },
            {
                title: 'Asunto',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'asunto');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'asunto'
            },
            {
                title: 'Petición',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'peticion');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'peticion'
            },
            {
                title: 'Motivos Académicos',
                visible: false,
                searchable: false,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'motivosA');
                },

                data: 'motivosA',
                render: function (data, type) {
                    var new_data = data

                    if (type === 'display') {

                        if (!data || data === null || data === 'null') {
                            new_data = 'Sin motivos';
                        }
                        else {
                            new_data;
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                }
            },
            {
                title: 'Motivos Personales',
                visible: false,
                searchable: false,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'motivosP');
                },

                data: 'motivosP',
                render: function (data, type) {
                    var new_data = data

                    if (type === 'display') {

                        if (!data || data === null || data === 'null') {
                            new_data = 'Sin motivos';
                        }
                        else {
                            new_data;
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                }
            },
            {
                title: 'Otros motivos',
                visible: false,
                searchable: false,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'otrosM');
                },

                data: 'otrosM',
                render: function (data, type) {
                    var new_data = data

                    if (type === 'display') {

                        if (!data || data === null || data === 'null') {
                            new_data = 'Sin motivos';
                        }
                        else {
                            new_data;
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                }
            },
            {
                title: 'Anexos',
                visible: false,
                searchable: false,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'anexos');
                },

                data: 'anexos',
                render: function (data, type) {
                    var new_data = data

                    if (type === 'display') {

                        if (!data || data === null || data === 'null') {
                            new_data = 'Sin anexos';
                        }
                        else {
                            new_data;
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                }
            },
            {
                title: 'Firma',
                visible: true,
                searchable: false,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'firma_alumno');
                },

                render: function (data, type, row, meta) {
                    // Assuming 'firma_alumno' contains the image source
                    var imageUrl = escapeHtml(data);

                    // Check if the image source is available
                    if (imageUrl) {
                        // Concatenate the BASE_URL with the image source
                        var fullImageUrl = BASE_URL + imageUrl;

                        // Return the HTML for the image tag
                        return '<img src="' + fullImageUrl + '" alt="Firma del alumno" style="max-width: 100px; max-height: 100px;">';
                    } else {
                        // If 'firma_alumno' is not available or empty, you can handle it accordingly
                        return 'Sin firma';
                    }
                },
                data: 'firma_alumno'
            },
            {
                title: 'Teléfono',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'telefono');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'telefono'
            },
            {
                title: 'correo',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'correo');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'correo'
            },
            {
                title: 'Observaciones',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'observaciones');
                },

                data: 'observaciones',
                render: function (data, type, row, meta) {
                    var new_data = data

                    if (type === 'display') {

                        if (!data || data === null || data === 'null') {
                            new_data = 'Sin observaciones';
                        }
                        else {
                            new_data;
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                },
            },
            {
                title: 'Respuesta',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'respuesta');
                },

                data: 'resp_solicitud',
                render: function (data, type, row, meta) {
                    var new_data = data

                    if (type === 'display') {

                        if (data === 'Aceptado') {
                            new_data = '<span class="label label-success">Aceptado</span>';
                        }
                        else if (data === 'Rechazado') {
                            new_data = '<span class="label label-danger">Rechazado</span>';
                        } else {
                            new_data = '<span class="label label-warning">Pendiente</span>';
                        }

                        return (
                            new_data
                        );
                    }

                    return new_data;
                },
            }
        ],
        select: {
            style: 'multi',
            selector: 'td.select-checkbox'
        },
        order: [[1, 'asc']], // Set the default sorting column and order
        columnDefs: [
            {
                targets: ['_all'],
                className: 'mdc-data-table__cell',
                'orderable': false,
                'checkboxes': {
                    'selectRow': true
                }
            }
        ],
        rowReorder: {
            selector: 'td:first-child', // Set the selector to target the first column
            dataSrc: 'nControl',
            update: false
        }
    });

    // Fetch data from the server
    $.ajax({
        type: 'GET',
        url: 'fetchFDCDataByCareer',
        dataType: 'json',
        success: function (data) {

            // Clear existing data in the table
            table1.clear();

            if (data.length > 0) {
                // Add new data to the table
                table1.rows.add(data);

                // Redraw the table
                table1.draw();
            } else {
                console.log("No data received.");
                // Handle the case when no data is returned
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data: ', error);
        }
    });

    // Handle form submission event
    $('#checkedFDC').on('submit', function (e) {
        var form = this;

        // Retrieve selectedRows from local storage on form submission
        selectedRows = JSON.parse(localStorage.getItem('selectedRows')) || [];

        // Output 'nControl' values to the console
        $('#example-console-rows').text(selectedRows.join(","));

        // Create hidden elements for each selected row
        selectedRows.forEach(function (nControl) {
            // Create a hidden element for 'nControl'
            $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id[]')
                    .val(nControl)
            );
        });

        // Output form data to a console  
        $('#example-console-form').text($(form).serialize());

        // Remove added elements
        $('input[name="id\[\]"]', form).remove();

        // Prevent actual form submission
        e.preventDefault();

    });

    var entityMap = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
    };

    function escapeHtml(string) {
        if (string == null) {
            return '';
        }
        return String(string).replace(/[&<>"'`=\/]/g, function (s) {
            return entityMap[s];
        });
    }

    // Declare selectedNControls as a global variable
    var selectedNControls = [];

    // Function to open iziModal
    function openIziModal() {
        $("#ModalObsFDC").iziModal({
            title: 'F-DC-15',
            subtitle: 'Añadir una observación para: ' + selectedNControls.join(', '),
            icon: 'icon-home',
            headerColor: '#88A0B9',
            zindex: 1050,
            onOpening: function (modal) {

                // Add event listener to the input field for form submission
                $('#observationFDC').on('keydown', function (e) {
                    if (e.key === 'Enter') {
                        // Code to execute when opening the modal
                        modal.startLoading();
                        submitFormAndClose();
                        modal.stopLoading();
                        e.preventDefault();
                    }
                });

                // Add event listener to the form for submission
                $('#observationFDCForm').on('submit', function (e) {
                    // Code to execute when opening the modal
                    modal.startLoading();
                    submitFormAndClose();
                    modal.stopLoading();
                    e.preventDefault();
                });
            }
        });
    }

    // Function to submit the form data and close the iziModal
    function submitFormAndClose() {
        var observation = $('#observationFDC').val();

        // Call the function to send a POST request and fetch modal content
        sendPostRequest(selectedNControls, observation);

        // Close the iziModal
        $("#ModalObsFDC").iziModal('close');
    }

    // Handle row selection/deselection
    $('#example3 tbody').on('click', 'tr', function (e) {
        // Toggle the selected class on the clicked row
        e.currentTarget.classList.toggle('selected');

        // Use setTimeout to wait for the DataTable to process the selection
        setTimeout(function () {
            // Update the selectedRows array on each selection
            selectedRows = table1.rows('.selected').data().toArray();

            // Save selectedRows to local storage
            localStorage.setItem('selectedRows', JSON.stringify(selectedRows.map(row => row.nControl)));

            // Output 'nControl' values to the console
            $('#example-console-rows').text(selectedRows.map(row => row.nControl).join(","));

            // Update selectedNControls
            selectedNControls = selectedRows.map(row => row.nControl);
            console.log(selectedNControls);

            // Trigger form submission if at least one row is selected
            if (selectedRows.length > 0) {
                $('#checkedFDC').submit();
            }

        }, 0);

        e.preventDefault();
        checkButtonStatus();
    });

    // Function to update button status based on selected rows
    function checkButtonStatus() {
        // Get selected rows directly from DataTables API
        var selectedRows = table1.rows('.selected').data().toArray();

        // Extract 'nControl' values
        selectedNControls = selectedRows.map(row => row.nControl);

        // Enable or disable the button based on whether there are selected rows
        var button = document.getElementById('checkedFDCList');
        button.disabled = selectedNControls.length === 0;
    }

    // Function to update the subtitle text and open the iziModal
    function updateSubtitle() {
        // Destroy the existing modal instance
        $("#ModalObsFDC").iziModal('destroy');

        // Create and open the iziModal with the updated subtitle
        openIziModal();
    }

    // Add an event listener to the "Enviar" button
    document.getElementById('checkedFDCList').addEventListener('click', function () {
        // Get selected rows directly from DataTables API
        var selectedRows = table1.rows('.selected').data().toArray();

        // Extract 'nControl' values
        selectedNControls = selectedRows.map(row => row.nControl);

        // Call the function to update the subtitle text
        updateSubtitle();

        checkButtonStatus();
    });
});

// Function to show errors to the user
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

// Function to send a POST request with FormData
function sendPostRequest(selectedNControls, observation) {

    // Check if observation is null or empty
    if (!observation || observation.trim() === "") {
        // Show a toast message indicating that observation is required
        iziToast.error({
            title: 'Error',
            message: 'Por favor, introduzca una observación',
            position: 'topRight'
        });
        return;
    }

    // Create a FormData object
    const formData = new FormData();

    // Append selected 'nControl' values to the FormData
    selectedNControls.forEach(function (nControl) {
        formData.append('id[]', nControl);
    });

    // Append observation data to the FormData
    formData.append('observation', observation);
    console.log("No. Control seleccionado: " + selectedNControls.join(', '));
    console.log("Observación: " + observation);

    // Proceed with the AJAX request
    $.ajax({
        type: "POST",
        url: "sendCheckedFDCObs",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("Raw server response:", response); // Log the raw response
            var result = JSON.parse(response);
            // Handle the response from the server
            switch (result.status) {
                case "success":
                    Swal.fire({
                        position: 'top-end',
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
                    showError(result.message);
                    break;

                default:
                    // Handle other cases if needed
                    showError(result.message);
                    break;
            }
        }, error: function (xhr, status, error) {
            console.error(xhr.responseText);
            showError("Error en el servidor. Por favor, inténtelo de nuevo.");
        }
    });
}