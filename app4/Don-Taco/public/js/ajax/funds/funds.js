import { currencyRender, checkRequiredFields } from '../helper/helpers.js';

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
        { data: "date", title: "FECHA", datetimepicker: { timepicker: false, format: "Y/m/d" }, typeof: "date", required: true },
        { data: "saldo", title: "SALDO KLAR", type: "readonly", required: false, render: currencyRender },
        { data: "pagos", title: "PAGOS KLAR", typeof: "decimal", required: false, render: currencyRender },
        { data: "concepto", title: "CONCEPTO PAGOS KLAR", typeof: "string", required: false },
        { data: "observa", title: "OBSERVACIONES", typeof: "string", required: false }
    ];

    const tbl = $('#tableF').DataTable({
        ajax: {
            url: 'funds/fetch',
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

            if (!checkRequiredFields(rowdata, columnDefs, error, toast)) {
                return; // block submit if required fields missing
            }

            $.ajax({
                url: 'funds/insert',
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(data),
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    } else {
                        toast.error(res.message || 'Error desconocido');
                        error(res);
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

            if (!checkRequiredFields(rowdata, columnDefs, error, toast)) {
                return; // block submit if required fields missing
            }

            $.ajax({
                url: 'funds/update/' + rowdata.id,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    } else {
                        toast.error(res.message || 'Error desconocido');
                        error(res);
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
                url: 'funds/delete/' + id,
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
