$(document).ready(function () {

    // Initialize the Toasty library
    var toast = new Toasty(
        {
        classname: "toast",
        transition: "slideUpFade",
        insertBefore: false,
        enableSounds: true,
        sounds: {
            // path to sound for informational message:
            info: "../Toasty/sounds/info/3.mp3",
            // path to sound for successfull message:
            success: "../Toasty/sounds/success/3.mp3",
            // path to sound for warn message:
            warning: "../Toasty/sounds/warning/1.mp3",
            // path to sound for error message:
            error: "../Toasty/sounds/error/1.mp3",
        },
    });

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
            { data: 'price', title: 'PRECIO' }
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
                    toast.info("Tabla actualizada");
                }
            }
        ],
        onAddRow: function (datatable, rowdata, success, error) {
            $.ajax({
                url: 'product/insert',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    nombre: rowdata.name,
                    precio: rowdata.price
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
        }
    });
});