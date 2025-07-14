import { currencyRender, checkRequiredFields } from '../helper/helpers.js';

$(document).ready(function () {

    // Initialize the Toasty library
    const toast = new Toasty();

    let columDefs = [
        {
            data: null, title: "#", type: "hidden",
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'id', title: 'ID', visible: false, type: 'hidden' },
        { data: "date", title: "FECHA", datetimepicker: { timepicker: false, format: "Y/m/d" }, typeof: "date", required: true },
        { data: "rent", title: "RENTA", typeof: "decimal", required: false, render: currencyRender },
        { data: "luz", title: "LUZ", typeof: "decimal", required: false, render: currencyRender },
        { data: "gas_rich", title: "GASOLINA RICARDO", typeof: "decimal", required: false, render: currencyRender },
        { data: "gas_milt", title: "GASOLINA MILTON", typeof: "decimal", required: false, render: currencyRender },
        { data: "gas", title: "GAS", typeof: "decimal", required: false, render: currencyRender },
        { data: "refrsco", title: "REFRESCO", typeof: "decimal", required: false, render: currencyRender },
        { data: "ver_sem", title: "VERDURAS SEMANAL", typeof: "decimal", required: false, render: currencyRender },
        { data: "fond_ta", title: "FONDO TAQUERÍA", typeof: "decimal", required: false, render: currencyRender }
    ];

    // Initialize DataTable
    const tbl = $('#tableGFD').DataTable({
        ajax: {
            url: 'gastosfd/fetch',
            dataSrc: ''
        },
        columns: columDefs,
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

            if (!checkRequiredFields(rowdata, columDefs, error, toast)) {
                return; // block submit if required fields missing
            }

            $.ajax({
                url: 'gastosfd/insert',
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Mensaje del sistema:", message);
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },

        onEditRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            if (!checkRequiredFields(rowdata, columDefs, error, toast)) {
                return; // block submit if required fields missing
            }

            $.ajax({
                url: 'gastosfd/update/' + rowdata.id,
                type: 'PUT',
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Mensaje del sistema:", message);
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },
        // Delete record
        onDeleteRow: function (datatable, rowdata, success, error) {

            const id = rowdata[0]?.id;

            $.ajax({
                url: 'gastosfd/delete/' + id,
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
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