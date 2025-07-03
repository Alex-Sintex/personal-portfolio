import { currencyRender, checkAllDecimalFields } from '../helper/helpers.js';
import { attachInfoToAltEditorModal } from '../helper/modalHelpers.js';

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
        { data: "date", title: "FECHA", type: "hidden" },
        { data: "rent", title: "RENTA", typeof: "decimal", render: currencyRender },
        { data: "luz", title: "LUZ", typeof: "decimal", render: currencyRender },
        { data: "gas_rich", title: "GASOLINA RICARDO", typeof: "decimal", render: currencyRender },
        { data: "gas_milt", title: "GASOLINA MILTON", typeof: "decimal", render: currencyRender },
        { data: "gas", title: "GAS", typeof: "decimal", render: currencyRender },
        { data: "refrsco", title: "REFRESCO", typeof: "decimal", render: currencyRender },
        { data: "ver_sem", title: "VERDURAS SEMANAL", typeof: "decimal", render: currencyRender },
        { data: "fond_ta", title: "FONDO TAQUERÍA", typeof: "decimal", render: currencyRender }
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

            if (!checkAllDecimalFields(data, columDefs, error, toast)) return;

            // set current date if empty
            if (!data.date || data.date === "") {
                const today = new Date().toISOString().slice(0, 10);
                data.date = today;
            }

            $.ajax({
                url: 'gastosfd/insert',
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
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

            if (!checkAllDecimalFields(data, columDefs, error, toast)) return;

            $.ajax({
                url: 'gastosfd/update/' + rowdata.id,
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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        console.log("⚠️ Error de validación:", message);
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

    attachInfoToAltEditorModal({
        message: `Para ver reflejado correctamente la fecha,
                  debe insertar un nuevo registro en el módulo de <strong>Balance</strong>, de lo contrario, 
                  se mostrará temporalmente la fecha actual del registro.`,
        fieldAfterId: 'alteditor-row-fond_ta', // form-group container ID to insert message after
        alertId: 'alert-info-message-unique'   // Unique ID for the alert block
    });
});