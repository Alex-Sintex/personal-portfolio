$(document).ready(function () {

    var columnDefs = [{
        data: "AG_Act",
        title: "No",
        type: "readonly"
    },
    {
        data: "responsableAct",
        title: "Responsable"
    },
    {
        data: "nom_alumAct",
        title: "Nombre del alumno"
    },
    {
        data: "nControlAlumAct",
        title: "No. Control"
    },
    {
        data: "carAlumAct",
        title: "Carrera"
    },
    {
        data: "resolAct",
        title: "Respuesta"
    },
    {
        data: null,
        title: "Acción",
        name: "Acción",
        render: function (data, type, row, meta) {
            return '<i class="delbutton delete-btn btn fa fa-trash btn btn-danger"></i>';
        },
        disabled: true
    }
    ];

    var myTable;

    myTable = $('#tbAG').DataTable({
        ajax: {
            url: 'fetchActaGralReqData',
            type: 'GET',
            dataSrc: '' // Empty string if the data is not wrapped in a property
        },
        columns: columnDefs,
        dom: 'Bfrtip',        // Needs button container
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

    function refreshTable() {
        // Fetch data from the server
        $.ajax({
            type: 'GET',
            url: 'fetchActaGralReqData',
            data: {}, // You may need to pass additional parameters if required
            dataType: 'json',
            success: function (data) {
                // Compare the fetched data with the current table data
                var currentData = myTable.rows().data().toArray();

                if (!arraysEqual(data, currentData)) {
                    // Clear existing data in the table
                    myTable.clear();

                    // Add new data to the table
                    myTable.rows.add(data);

                    // Redraw the table
                    myTable.draw();
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

    // Set an interval to periodically check for new values (every 5 seconds in this example)
    setInterval(refreshTable, 5000);

    // Edit
    $(document).on('click', "[id^='tbAG'] tbody ", 'tr', function () {
        var tbAG = $(this).closest('table').attr('id');    // id of the table
        var that = $('#' + tbAG)[0].altEditor;
        that._openEditModalAG();
        $('#altEditor-edit-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();
                that._editRowDataAG();
            });
    });

    // Delete
    $(document).on('click', "[id^='tbAG'] .delbutton", 'tr', function (x) {
        var tbAG = $(this).closest('table').attr('id');    // id of the table
        var that = $('#' + tbAG)[0].altEditor;
        that._openDeleteModalAG();
        $('#altEditor-delete-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();
                that._deleteRow();
            });
        x.stopPropagation(); //avoid open "Edit" dialog
    });
});