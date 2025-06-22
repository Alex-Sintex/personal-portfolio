$(document).ready(function () {
    /*
      $.getJSON('../../json/data.json', function (dataSet) {});
    */

    // Initialize the Toasty library
    const toast = new Toasty();

    const nom_uni_med = [
        'paquete',
        'kilo',
        'pieza',
        'rollo',
        'manojo',
        'caja',
        'barra',
        'bolsa'
    ];

    const nom_prov = [
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

    // Define columns in table
    const columnDefs = [
        {
            data: null,
            title: '#',
            type: 'hidden',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'id',
            title: 'ID',
            visible: false,
            type: 'hidden'
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
        language: {
            url: "../../JSON/es-ES.json"
        },
        buttons: [
            { text: '➕ Añadir', name: 'add' },
            { extend: 'selected', text: '✏️ Editar', name: 'edit' },
            { extend: 'selected', text: '❌ Borrar', name: 'delete' }
        ],
        // Insert new record
        onAddRow: function (datatable, rowdata, success, error) {
            $.ajax({
                url: 'product/insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: rowdata.name,
                    price: rowdata.price,
                    measure_n: rowdata.measure_n,
                    provider_n: rowdata.provider_n
                }),
                success: function (res) {
                    if (res.status === 'success') {
                        table.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res); // Only call success
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },
        // Edit record
        onEditRow: function (datatable, rowdata, success, error) {
            $.ajax({
                url: 'product/update/' + rowdata.id,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: rowdata.name,
                    price: rowdata.price,
                    measure_n: rowdata.measure_n,
                    provider_n: rowdata.provider_n
                }),
                success: function (res) {
                    if (res.status === 'success') {
                        table.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    } else {
                        // Only call error if status is not success
                        toast.error(res.message || "Error al actualizar");
                        error(res);
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
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
                url: 'product/delete/' + id,
                type: 'DELETE',
                success: function (res) {
                    if (res.status === 'success') {
                        table.ajax.reload(null, false);
                        toast.success(res.message);
                        success(res);
                    } else {
                        // Only call error if status is not success
                        toast.error(res.message || "Error al eliminar");
                        error(res);
                    }
                },
                error: function (xhr) {
                    let message = "Error en el servidor";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        }
    });
});