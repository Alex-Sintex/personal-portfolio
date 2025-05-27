$(document).ready(function () {

    // Initialize the Toasty library
    var toast = new Toasty();

    var nom_uni_med = [
        'paquete',
        'kilo',
        'pieza',
        'rollo',
        'manojo',
        'caja',
        'barra',
        'bolsa'
    ];

    var nom_prov = [
        'Bodegón',
        'Chedraui',
        'Embutidos San José',
        'La cosecha dorada',
        'Verdulería Domínguez',
        'Mundi Novi',
        'Oxxo',
        'Tortillería T-2000',
        'Carnicería La Oriental'
    ];

    var table = $('#tableP').DataTable({
        ajax: {
            url: 'product/fetch',
            dataSrc: ''
        },
        columns: [
            {
                data: 'id', type: 'hidden', title: '#', render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'name', title: 'NOMBRE PRODUCTO' },
            { data: 'price', title: 'PRECIO' },
            {
                data: 'measure_n',
                title: 'UNIDAD DE MEDIDA',
                type: 'select',
                options: nom_uni_med,
                select2: { width: '100% ' },
                render: function (data, type, row, meta) {
                    if (data == null || row == null || row.measure_n == null) return null;
                    return row.measure_n;
                }
            },
            {
                data: 'provider_n',
                title: 'PROVEEDOR',
                type: 'select',
                options: nom_prov,
                select2: { width: '100%' },
                render: function (data, type, row, meta) {
                    if (data == null || row == null || row.provider_n == null) return null;
                    return row.provider_n;
                }
            }
        ],
        dom: 'Bfrtip',
        select: 'single',
        language: {
            url: "../../JSON/es-ES.json"
        },
        responsive: true,
        altEditor: true,
        buttons: [
            { text: '➕ Añadir', name: 'add' },
            { extend: 'selected', text: '✏️ Editar', name: 'edit' },
            { extend: 'selected', text: '❌ Borrar', name: 'delete' },
            {
                text: '🔄 Refrescar',
                action: function (e, dt) {
                    table.ajax.reload(null, false);
                    toast.info("¡Tabla actualizada!");
                }
            }
        ],
        /*onAddRow: function (datatable, rowdata, success, error) {
            $.ajax({
                url: 'product/insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: rowdata.name,
                    price: rowdata.price
                }),
                success: function (res) {
                    if (res.status === 'ok' || res.status === 'Added') {
                        table.ajax.reload(null, false);
                        toast.success("Producto agregado");
                        success(res);
                    } else {
                        toast.error("Error al agregar");
                        error();
                    }
                },
                error: function () {
                    toast.error("Error en el servidor");
                    error();
                }
            });
        },

            onEditRow: function (datatable, rowdata, success, error) {
                $.ajax({
                    url: 'product/update/' + rowdata.id,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        nombre: rowdata.name,
                        precio: rowdata.price
                    }),
                    success: function (res) {
                        if (res.status === 'ok' || res.status === 'Updated') {
                            table.ajax.reload(null, false);
                            toast.success("Producto actualizado");
                            success(res);
                        } else {
                            toast.error("Error al actualizar");
                            error();
                        }
                    },
                    error: function () {
                        toast.error("Error en el servidor");
                        error();
                    }
                });
            },
            onDeleteRow: function (datatable, rowdata, success, error) {
                $.ajax({
                    url: 'product/delete/' + rowdata.id,
                    type: 'DELETE',
                    success: function (res) {
                        if (res.status === 'ok' || res.status === 'Deleted') {
                            table.ajax.reload(null, false);
                            toast.success("Producto eliminado");
                            success(res);
                        } else {
                            toast.error("Error al eliminar");
                            error();
                        }
                    },
                    error: function () {
                        toast.error("Error en el servidor");
                        error();
                    }
                });
            }*/
    });

    // Add row
    $(document).on('click', '.buttonDT:contains("➕ Añadir")', function (e) {
        var that = $('#tableP')[0].altEditor;
        that._openAddModal();
        $('#altEditor-add-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                toast.success("¡Producto agregado!");
                e.preventDefault();
                e.stopPropagation();
                that._addRowData();
            });

        e.stopPropagation(); // evita que se abra el modal de edición
    });

    // Edit
    $(document).on('click', "[id^='tableP'] .buttonDT:contains('✏️ Editar')", function (e) {
        const table = $(this).closest('div.dt-buttons').siblings('table[id^="tableP"]');
        const tableID = table.attr('id');

        if (!tableID) return;

        const that = $('#' + tableID)[0].altEditor;

        that._openEditModal();

        $('#altEditor-edit-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                toast.success("¡Producto editado!");
                e.preventDefault();
                e.stopPropagation();
                that._editRowData();
            });

        e.stopPropagation(); // evita que se abra el modal de edición
    });

    // Delete
    $(document).on('click', "[id^='tableP'] .buttonDT:contains('❌ Borrar')", function (e) {
        const table = $(this).closest('div.dt-buttons').siblings('table[id^="tableP"]');
        const tableID = table.attr('id');

        if (!tableID) return;

        const that = $('#' + tableID)[0].altEditor;

        that._openDeleteModal();

        $('#altEditor-delete-form-' + that.random_id)
            .off('submit')
            .on('submit', function (e) {
                toast.success("¡Producto eliminado!");
                e.preventDefault();
                e.stopPropagation();
                that._deleteRow();
            });

        e.stopPropagation(); // evita que se abra el modal de edición
    });
});