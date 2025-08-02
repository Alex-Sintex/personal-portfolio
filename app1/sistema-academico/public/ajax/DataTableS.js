// confirm_sendFDC.js
$(document).ready(function () {

    // Table 1: Example 1
    var table = $('#example1').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'excel',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                download: 'open', filename: function () {
                    return "F-DC-15 Tabla"
                },
                title: function () {
                    var searchString = table.search();
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
                visible: false,
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
                visible: false,
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
                visible: false,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'observaciones');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'observaciones'
            },
            {
                title: 'Respuesta',
                visible: false,
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
            selector: 'td:first-child'
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

    // Function to fetch and update data
    function fetchDataAndUpdateTable() {
        var user_career = $('#careerSelect').val();

        // Fetch data from the server
        $.ajax({
            type: 'POST',
            url: 'fetchFDCData',
            data: { user_career: user_career },
            dataType: 'json',
            success: function (data) {
                // Clear existing data in the table
                table.clear();

                // Add new data to the table
                table.rows.add(data);

                // Redraw the table
                table.draw();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data: ', error);
            }
        });
    }

    // Event listener for career selection change
    $('#careerSelect').on('change', function () {
        fetchDataAndUpdateTable();
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
});
