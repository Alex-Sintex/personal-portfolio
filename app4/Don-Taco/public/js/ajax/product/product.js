import { checkRequiredFields } from '../helper/helpers.js';

$(document).ready(function () {
    // Initialize the Toasty library
    const toast = new Toasty();

    // Fetch both unit measures and suppliers
    $.when(
        $.getJSON('unitoms/fetch'),
        $.getJSON('suppliers/fetch')
    ).done(function (unitRes, supRes) {
        const nom_uni_med = unitRes[0].map(u => u.unit_n);
        const nom_sup = supRes[0].map(p => p.name_prov);

        // Now initialize DataTable
        initProductTable(nom_uni_med, nom_sup);
    }).fail(function () {
        toast.error("Error al cargar datos de unidades o proveedores.");
    });

    function initProductTable(unitOptions, supOptions) {
        const columnDefs = [
            {
                data: null,
                title: '#',
                type: 'hidden',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'id', title: 'ID', visible: false, type: 'hidden' },
            { data: 'name', title: 'NOMBRE PRODUCTO' },
            { data: 'price', title: 'PRECIO' },
            {
                data: 'measure_n',
                title: 'UNIDAD DE MEDIDA',
                type: 'select',
                options: unitOptions,
                select2: { 'placeholder': 'Selecciona una opción', width: '100%' },
                render: function (data, type, row) {
                    return row?.measure_n ?? null;
                }
            },
            {
                data: 'provider_n',
                title: 'PROVEEDOR',
                type: 'select',
                options: supOptions,
                select2: { 'placeholder': 'Selecciona una opción', width: '100%' },
                render: function (data, type, row) {
                    return row?.provider_n ?? null;
                }
            }
        ];

        const table = $('#tableP').DataTable({
            ajax: {
                url: 'product/fetch',
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
                    url: 'product/insert',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function (res) {
                        if (res.status === 'success') {
                            table.ajax.reload(null, false);
                            toast.success(res.message);
                            success(res);
                        } else {
                            toast.error(res.message || "Error al añadir");
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

                if (!checkRequiredFields(rowdata, columnDefs, error, toast)) {
                    return; // block submit if required fields missing
                }

                $.ajax({
                    url: 'product/update/' + rowdata.id,
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function (res) {
                        if (res.status === 'success') {
                            table.ajax.reload(null, false);
                            toast.success(res.message);
                            success(res);
                        } else {
                            toast.error(res.message || "Error al editar");
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
                    url: 'product/delete/' + id,
                    type: 'DELETE',
                    success: function (res) {
                        if (res.status === 'success') {
                            table.ajax.reload(null, false);
                            toast.success(res.message);
                            success(res);
                        } else {
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
    }
});
