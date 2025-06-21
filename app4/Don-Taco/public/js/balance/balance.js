import { currencyRender, checkAllDecimalFields, parseNumber } from '../helper/helpers.js';

$(document).ready(function () {
    const toast = new Toasty();

    let columInDefs = [
        {
            data: null,
            title: "#",
            type: 'hidden',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: "date", title: "FECHA", datetimepicker: { timepicker: false, format: "Y/m/d" }, typeof: "date" },
        { data: "gastEfect", title: "GASTOS EN EFECTIVO", typeof: "decimal", render: currencyRender },
        { data: "ventEfect", title: "VENTA EFECTIVO", typeof: "decimal", render: currencyRender },
        { data: "ventTransf", title: "VENTA TRANSFERENCIA", typeof: "decimal", render: currencyRender },
        { data: "ventNetTar", title: "VENTA NETA TARJETA", typeof: "decimal", render: currencyRender },
        { data: "depPlatf", title: "DEPÓSITOS PLATAFORMAS", typeof: "decimal", render: currencyRender },
        { data: "nomPlatf", title: "NOMBRE PLATAFORMA", typeof: "string" },
        { data: "reparUtil", title: "REPARTO UTILIDADES", typeof: "decimal", render: currencyRender },
        { data: "ub", title: "UBER", typeof: "decimal", render: currencyRender },
        { data: "did", title: "DIDI", typeof: "decimal", render: currencyRender },
        { data: "rap", title: "RAPPI", typeof: "decimal", render: currencyRender },
        { data: "totGF", title: "TOTAL GASTO FIJO", typeof: "decimal", render: currencyRender }
    ];

    const inTbl = $('#inTableB').DataTable({
        ajax: {
            url: 'balance/fetch',
            dataSrc: ''
        },
        columns: columInDefs,
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

            if (!checkAllDecimalFields(data, columInDefs, error, toast)) return;

            $.ajax({
                url: 'balance/insert',
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(data),
                success: function (res) {
                    //console.log('AJAX success:', res);
                    if (res.status === 'success') {
                        inTbl.ajax.reload(() => {
                            updateCalTbl(); // only update after reload
                        }, false);
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
                        console.log("⚠️ Mensaje del sistema:", message)
                    }
                    toast.error(message);
                    error(xhr);
                }
            });
        },

        onEditRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            if (!checkAllDecimalFields(data, columInDefs, error, toast)) return;

            inTbl.row({ selected: true }).data(data).draw();
            toast.success("Actualizado correctamente");
            updateCalTbl();
            success(data);
        },

        onDeleteRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;
            //console.log(data);

            inTbl.row({ selected: true }).remove().draw();
            toast.success("Eliminado correctamente");
            updateCalTbl();
            success(data);
        }
    });

    let columCalDefs = [
        {
            data: null,
            title: '#',
            type: 'hidden',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'utilidadNeta', title: 'UTILIDAD NETA', render: currencyRender },
        { data: 'totalEgresos', title: 'TOTAL EGRESOS', render: currencyRender },
        { data: 'efectivoCierre', title: 'EFECTIVO AL CIERRE', render: currencyRender },
        { data: 'ventaTarjeta', title: 'VENTA TARJETA - %', render: currencyRender },
        { data: 'totalIngresos', title: 'TOTAL INGRESOS', render: currencyRender },
        { data: 'utilidadPiso', title: 'UTILIDAD PISO', render: currencyRender },
        { data: 'utilidadDisponible', title: 'UTILIDAD DISPONIBLE', render: currencyRender },
        { data: 'total', title: 'TOTAL', render: currencyRender },
        { data: 'utilidadPlataforma', title: 'UTILIDAD NETA PLATAFORMA', render: currencyRender }
    ];

    $('#calTableB').DataTable({
        ajax: {
            url: 'balance/fetch_cal',
            dataSrc: ''
        },
        columns: columCalDefs,
        dom: 'Bfrtip',
        responsive: true,
        altEditor: false,
        language: { url: "../../JSON/es-ES.json" },
        buttons: [
            {
                extend: 'print',
                title: 'Reporte',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function (win) {
                    // Basic print styles
                    $(win.document.body).css({
                        'font-family': 'Arial, sans-serif',
                        'font-size': '10pt',
                        'position': 'relative',
                    });

                    // Add watermark logo behind table
                    $(win.document.body).prepend(`
                        <img src="https://localhost/img/Logo/Logo.png"
                            style="
                                position: fixed;
                                top: 35%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                                opacity: 0.5;
                                width: 50%;
                                z-index: -1;
                            "
                        />
                    `);

                    // Report title
                    $(win.document.body).prepend(`
                        <div style="text-align: center; margin-bottom: 30px;">
                            <h2 style="margin: 0;">DON TACO</h2>
                            <h3 style="margin: 0;">Balance Diario</h3>
                        </div>
                    `);

                    // Header styling
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#f2f2f2',
                        'font-weight': 'bold'
                    });

                    // Table borders
                    $(win.document.body).find('table').css({
                        'border-collapse': 'collapse',
                        'width': '100%'
                    });

                    $(win.document.body).find('table th, table td').css({
                        'border': '1px solid #444',
                        'padding': '8px',
                        'text-align': 'center'
                    });
                }
            },
            'colvis'
        ]
    });
});
