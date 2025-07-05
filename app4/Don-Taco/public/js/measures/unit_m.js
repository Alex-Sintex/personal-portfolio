$(document).ready(function () {
    const toast = new Toasty();

    const columnDefs = [
        {
            data: null,
            title: "#",
            type: "hidden",
            render: (data, type, row, meta) => meta.row + 1
        },
        { data: 'id', title: 'ID', visible: false, type: 'hidden' },
        { data: "unit_n", title: "NOMBRE DE LA MEDIDA", typeof: "string" },
        { data: "unit_d", title: "DESCRIPCIÓN DE LA MEDIDA", typeof: "string" }
    ];

    const tbl = $('#UoMTbl').DataTable({
        ajax: {
            url: 'unitoms/fetch',
            dataSrc: ''
        },
        columns: columnDefs,
        dom: 'Bfrtip',
        select: 'single',
        responsive: true,
        altEditor: true,
        language: { url: "../../JSON/es-ES.json" },
        buttons: [
            { text: '➕ Añadir', name: 'add' },
            { extend: 'selected', text: '✏️ Editar', name: 'edit' },
            { extend: 'selected', text: '❌ Borrar', name: 'delete' }
        ],

        onAddRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            // set date if empty
            if (!data.date || data.date.trim() === "") {
                data.date = new Date().toISOString().slice(0, 10);
            }

            $.ajax({
                url: 'unitoms/insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Error de validación:", message);
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },

        onEditRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            $.ajax({
                url: 'unitoms/update/' + rowdata.id,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Error de validación:", message);
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },

        onDeleteRow: function (datatable, rowdata, success, error) {
            const id = rowdata[0]?.id;

            $.ajax({
                url: 'unitoms/delete/' + id,
                type: 'DELETE',
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Error de validación:", message);
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        }
    });
});
