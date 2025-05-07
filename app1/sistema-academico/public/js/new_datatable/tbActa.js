/**
 *
 * Author: K3VIN ALEXIS
 *
 */

$(document).ready(function () {

    // Table 1: Actas académicas
    var tbActa = $('#tbActa').DataTable({
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
        dom: 'Bfrtip',        // Needs button container
        select: 'single',
        responsive: true,
        altEditor: true,     // Enable altEditor
        buttons: [
            {
                text: 'Add',
                name: 'add'        // do not change name
            },
            {
                extend: 'selected', // Bind to Selected row
                text: 'Edit',
                name: 'edit'        // do not change name
            },
            {
                extend: 'selected', // Bind to Selected row
                text: 'Delete',
                name: 'delete'      // do not change name
            },
            {
                text: 'Refresh',
                name: 'refresh'      // do not change name
            }
        ],
        onDeleteRow: function (tbActa, rowdata, success, error) {
            $.ajax({
                // a tipycal url would be /{id} with type='DELETE'
                url: url_ws_mock_ok,
                type: 'GET',
                data: rowdata,
                success: success,
                error: error
            });
        },
        onEditRow: function (tbActa, rowdata, success, error) {
            $.ajax({
                // a tipycal url would be /{id} with type='POST'
                url: url_ws_mock_ok,
                type: 'GET',
                data: rowdata,
                success: success,
                error: error
            });
        }
    });

    // ======================================================================================

    var columnDefs2 = [{
        data: "id",
        title: "Id",
        type: "readonly"
    },
    {
        data: "name",
        title: "Name"
    },
    {
        data: "office",
        title: "Office"
    },
    {
        data: "startDate",
        title: "Start date"
    },
    {
        data: "position",
        title: "Position"
    }];

    var myOtherTable = $('#example2').DataTable({
        "sPaginationType": "full_numbers",
        ajax: {
            url: url_ws_mock_get,
            // our data is an array of objects, in the root node instead of /data node, so we need 'dataSrc' parameter
            dataSrc: ''
        },
        columns: columnDefs2,
        dom: 'Bfrtip',        // Needs button container
        select: 'single',
        responsive: true,
        altEditor: true,     // Enable altEditor
        buttons: [
            {
                text: 'Add',
                name: 'add'        // do not change name
            },
            {
                extend: 'selected', // Bind to Selected row
                text: 'Edit',
                name: 'edit'        // do not change name
            },
            {
                extend: 'selected', // Bind to Selected row
                text: 'Delete',
                name: 'delete'      // do not change name
            },
            {
                text: 'Refresh',
                name: 'refresh'      // do not change name
            }
        ],
        onAddRow: function (datatable, rowdata, success, error) {
            $.ajax({
                // a tipycal url would be / with type='PUT'
                url: url_ws_mock_ok,
                type: 'GET',
                data: rowdata,
                success: success,
                error: error
            });
        },
        onDeleteRow: function (datatable, rowdata, success, error) {
            $.ajax({
                // a tipycal url would be /{id} with type='DELETE'
                url: url_ws_mock_ok,
                type: 'DELETE',
                data: rowdata,
                success: success,
                error: error
            });
        },
        onEditRow: function (datatable, rowdata, success, error) {
            $.ajax({
                // a tipycal url would be /{id} with type='POST'
                url: url_ws_mock_ok,
                type: 'POST',
                data: rowdata,
                success: success,
                error: error
            });
        }
    });
});  