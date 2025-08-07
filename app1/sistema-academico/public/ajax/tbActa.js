// confirm_sendFDC.js
$(document).ready(function () {

    // Table 1: Example 1
    var table = $('#tbActa').DataTable({
        columns: [
            {
                title: 'Folio',
                width: '',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'no_solicitud');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'no_solicitud'
            },
            {
                title: 'Nombre del alumno',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'nom_alumAct');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'nom_alumAct'
            },
            {
                title: 'No. Control',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'nCtrlAlumActa');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'nCtrlAlumActa'
            },
            {
                title: 'Asunto',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'asuntoActa');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'asuntoActa'
            },
            {
                title: 'Resolución',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'resolucionAct');
                },

                data: 'resolucionAct', render: renderResolucion
            },
            {
                title: 'Recomendación',
                visible: true,
                searchable: true,

                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-columnname', 'recomenActa');
                },

                render: function (data, type, row, meta) {
                    return escapeHtml(data);
                },
                data: 'recomenActa'
            },
            {
                title: 'Acción',
                orderable: false,
                searchable: false,
                disabled: true
            }
        ],
        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent: '<i class="delBtn btn fa fa-trash btn btn-danger" aria-hidden="true"></i>'
            }
        ],
        dom: 'Bfrtip',
        select: {
            style: 'single',
            toggleable: false
        },
        responsive: true,
        altEditor: true,     // Enable altEditor
        buttons: [
            'colvis', // Column visibility button
            'print',  // Print button
            'excel'   // Excel export button
        ]
    });

    // Edit
    $(document).on('click', "[id^='tbActa'] tbody td[data-columnname='no_solicitud']", function () {
        var tableID = $(this).closest('table').attr('id');    // id of the table
        var that = $('#' + tableID)[0].altEditor;
        that._openEditModalAct();
        $('#altEditor-edit-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();
                that._editRowData();
            });
    });

    // Delete
    $('#tbActa tbody').on('click', '.delBtn', function () {
        var row = table.row($(this).closest('tr'));
        var rowData = row.data();
        var rowId = rowData.no_solicitud;

        // Use SweetAlert for confirmation
        Swal.fire({
            title: "¿Estás seguro de borrar el registro seleccionado?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Borrar",
            cancelButtonText: "Cancelar",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Yes", proceed with deletion
                $.ajax({
                    type: 'POST',
                    url: 'deleteActaData',
                    data: { no_solicitud: rowId },
                    success: function (response) {
                        // Check the server's response and remove the row if successful
                        if (response.success) {
                            row.remove().draw();
                            Swal.fire("¡Borrado!", "Se ha eliminado el registro", "success");
                        } else {
                            console.error('Error deleting data on the server');
                            Swal.fire("Error", "Error deleting data on the server", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error deleting data: ', error);
                        Swal.fire("Error", "Error deleting data", "error");
                    }
                });
            } else {
                // User clicked "Cancel" or closed the alert
                iziToast.info({
                    title: 'Alerta',
                    message: '¡Operación cancelada!',
                    color: 'blue',
                    position: 'bottomRight'
                });
            }
        });
    });


    // Function to render 'Resolución' with label
    function renderResolucion(data, type, row, meta) {
        var new_data = data;
        if (type === 'display') {
            if (data === 'Aceptado') {
                new_data = '<span class="label label-success">Aceptado</span>';
            } else {
                new_data = '<span class="label label-danger">Rechazado</span>';
            }
            return new_data;
        }
        return new_data;
    }

    // Function to fetch and update data
    function fetchDataAndUpdateTable() {
        var analisis_data;

        // Fetch data from the server
        $.ajax({
            type: 'POST',
            url: 'fetchActaData',
            data: { analisis_data: analisis_data },
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

    function refreshTable() {
        // Fetch data from the server
        $.ajax({
            type: 'GET',
            url: 'fetchActaData',
            data: {},
            dataType: 'json',
            success: function (data) {
                // Compare the fetched data with the current table data
                var currentData = table.rows().data().toArray();

                if (!arraysEqual(data, currentData)) {
                    // Clear existing data in the table
                    table.clear();

                    // Add new data to the table
                    table.rows.add(data);

                    // Redraw the table
                    table.draw();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data: ', error);
            }
        });
    }

    // Function to compare two arrays for equality
    function arraysEqual(arr1, arr2) {
        if (arr1.length !== arr2.length) return false;

        for (var i = 0; i < arr1.length; i++) {
            if (!objectsEqual(arr1[i], arr2[i])) return false;
        }

        return true;
    }

    // Function to compare two objects for equality
    function objectsEqual(obj1, obj2) {
        return JSON.stringify(obj1) === JSON.stringify(obj2);
    }

    // Fetch data by default
    fetchDataAndUpdateTable();

    // Set an interval to periodically check for new values (every 5 seconds in this example)
    setInterval(function () {
        refreshTable(); // Optionally, you can also call the refreshTable function
    }, 5000);

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