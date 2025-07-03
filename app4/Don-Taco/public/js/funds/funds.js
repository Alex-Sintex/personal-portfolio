import { currencyRender, checkAllDecimalFields } from '../helper/helpers.js';

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
        { data: "date", title: "FECHA", type: "hidden" },
        { data: "saldo", title: "SALDO KLAR", type: "hidden", render: currencyRender },
        { data: "pagos", title: "PAGOS KLAR", typeof: "decimal", render: currencyRender },
        { data: "concepto", title: "CONCEPTO PAGOS KLAR", typeof: "string" },
        { data: "observa", title: "OBSERVACIONES", typeof: "string" }
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

            if (!checkAllDecimalFields(data, columnDefs, error, toast)) return;

            // set date if empty
            if (!data.date || data.date.trim() === "") {
                data.date = new Date().toISOString().slice(0, 10);
            }

            $.ajax({
                url: 'funds/insert',
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

            if (!checkAllDecimalFields(data, columnDefs, error, toast)) return;
            
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
