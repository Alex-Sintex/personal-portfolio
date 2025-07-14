import { checkRequiredFields } from '../helper/helpers.js';

$(document).ready(function () {

    // Initialize the Toasty library
    const toast = new Toasty();

    const columnDefs = [
        {
            data: null,
            title: "#",
            type: 'hidden',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'id', title: 'ID', visible: false, type: 'hidden' },
        { data: "date", title: "FECHA", type: 'hidden' },
        { data: "username", title: "NOMBRE DE USUARIO", typeof: "string", required: true },
        { data: "email", title: "CORREO", typeof: "email", required: false },
        { data: "passwd", title: "CONTRASEÑA", typeof: "password", type: 'password', visible: false, required: false },
        {
            data: "role",
            title: "TIPO DE USUARIO",
            type: 'select',
            typeof: "string",
            options: ['admin', 'regular'],
            select2: {
                placeholder: 'Selecciona una opción',
                width: '100%'
            },
            required: true
        }
    ];

    const tbl = $('#usrTbl').DataTable({
        ajax: {
            url: 'users/fetch',
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

            // Solo para agregar: obligar contraseña
            if (!data.passwd || data.passwd.trim() === "") {
                toast.error("La contraseña es obligatoria");
                return;
            }

            if (!checkRequiredFields(data, columnDefs, error, toast)) return;

            $.ajax({
                url: 'users/register',
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
                        toast.error(res.message || 'Error al agregar');
                        error({ responseJSON: res });
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

            // Validar campos requeridos, excepto la contraseña
            const filteredCols = columnDefs.filter(col => col.data !== "passwd");
            if (!checkRequiredFields(data, filteredCols, error, toast)) return;

            $.ajax({
                url: 'users/update/' + rowdata.id,
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
                        toast.error(res.message || 'Error al editar');
                        error({ responseJSON: res });
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

        onDeleteRow: function (datatable, rowdata, success, error) {

            const id = rowdata[0]?.id;

            $.ajax({
                url: 'users/delete/' + id,
                type: 'DELETE',
                success: function (res) {
                    if (res.status === 'success') {
                        tbl.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    } else {
                        // Only call error if status is not success
                        toast.error(res.message || "Error al eliminar");
                        error({ responseJSON: res });
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
        }
    });
});
