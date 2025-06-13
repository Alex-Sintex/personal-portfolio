$(document).ready(function () {
    const toast = new Toasty();

    // Check if value is either string or empty
    function check(value, title) {
        const isEmpty = typeof value === 'string' && value.trim() === '';
        const isNotNumber = isNaN(parseFloat(value));

        if (isEmpty || isNotNumber) {
            toast.error(`El campo numérico '${title}' no puede estar vacío ni contener texto no numérico.`);
            return false;
        }

        return true;
    }

    // Helper functions
    function parseNumber(value) {
        const num = parseFloat(String(value).replace(/,/g, '').trim());
        return isNaN(num) ? 0 : num;
    }

    function calculateVentaTarjeta(row) {
        return parseNumber(row.ventNetTar) * 0.9651;
    }

    function calculateTotalIngresos(row, ventaTarjeta) {
        return parseNumber(row.ventTransf) + ventaTarjeta + parseNumber(row.ventEfect);
    }

    function calculateUtilidadPiso(totalIngresos, row) {
        return totalIngresos + parseNumber(row.depPlatf);
    }

    function calculateUtilidadNetaPlataforma(row) {
        return (parseNumber(row.ub) + parseNumber(row.did) + parseNumber(row.rap)) / 2;
    }

    function calculateTotalEgresos(row, gastosDiarios) {
        return parseNumber(row.totGF) + gastosDiarios;
    }

    function calculateTotalPlataformas(row) {
        return parseNumber(row.ub) + parseNumber(row.did) + parseNumber(row.rap);
    }

    function calculateUtilidadDisponible(utilidadPiso, utilidadAnterior, row, gastosDiarios) {
        return (utilidadPiso + utilidadAnterior) - (parseNumber(row.reparUtil) + parseNumber(row.totGF) + gastosDiarios);
    }

    function calculateUtilidadNeta(utilidadPiso, utilidadNetPlataforma, totalEgresos) {
        return (utilidadPiso + utilidadNetPlataforma) - totalEgresos;
    }

    function updateCalTbl() {
        const data = inTbl.rows().data().toArray();
        calTbl.clear();

        let utilidadAnterior = 0;
        let gastosDiarios = 3439.50;

        data.forEach((row) => {
            const ventaTarjeta = calculateVentaTarjeta(row);
            const totalIngresos = calculateTotalIngresos(row, ventaTarjeta);
            const utilidadPiso = calculateUtilidadPiso(totalIngresos, row);
            const totalEgresos = calculateTotalEgresos(row, gastosDiarios);
            const utilidadPlataforma = calculateUtilidadNetaPlataforma(row);

            const utilidadNeta = calculateUtilidadNeta(utilidadPiso, utilidadPlataforma, totalEgresos);
            const efectivoCierre = parseNumber(row.ventEfect) - parseNumber(row.gastEfect);
            const utilidadDisponible = calculateUtilidadDisponible(utilidadPiso, utilidadAnterior, row, gastosDiarios);
            const totalPlataformas = calculateTotalPlataformas(row);

            calTbl.row.add({
                utilidadNeta: utilidadNeta.toFixed(2),
                totalEgresos: totalEgresos.toFixed(2),
                efectivoCierre: efectivoCierre.toFixed(2),
                ventaTarjeta: ventaTarjeta.toFixed(2),
                totalIngresos: totalIngresos.toFixed(2),
                utilidadPiso: utilidadPiso.toFixed(2),
                utilidadDisponible: utilidadDisponible.toFixed(2),
                total: totalPlataformas.toFixed(2),
                utilidadPlataforma: utilidadPlataforma.toFixed(2)
            });

            utilidadAnterior = utilidadDisponible;
        });

        calTbl.draw();
    }

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
        { data: "gastEfect", title: "GASTOS EN EFECTIVO", typeof: "decimal" },
        { data: "ventEfect", title: "VENTA EFECTIVO", typeof: "decimal" },
        { data: "ventTransf", title: "VENTA TRANSFERENCIA", typeof: "decimal" },
        { data: "ventNetTar", title: "VENTA NETA TARJETA", typeof: "decimal" },
        { data: "depPlatf", title: "DEPÓSITOS PLATAFORMAS", typeof: "decimal" },
        { data: "nomPlatf", title: "NOMBRE PLATAFORMA", typeof: "string" },
        { data: "reparUtil", title: "REPARTO UTILIDADES", typeof: "decimal" },
        { data: "ub", title: "UBER", typeof: "decimal" },
        { data: "did", title: "DIDI", typeof: "decimal" },
        { data: "rap", title: "RAPPI", typeof: "decimal" },
        { data: "totGF", title: "TOTAL GASTO FIJO", typeof: "decimal" }
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
            { extend: 'selected', text: '❌ Borrar', name: 'delete' },
            {
                text: '🔄 Generar cálculos',
                action: function () {
                    updateCalTbl();
                    toast.info("¡Se han generado los cálculos en la primera tabla!");
                }
            }
        ],

        onAddRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            for (let colDef of columInDefs) {
                if (colDef.typeof === "decimal") {
                    const value = data[colDef.data];
                    if (!check(value, colDef.title)) {
                        error(data);
                        return;
                    }
                }
            }

            toast.success("Agregado correctamente");
            updateCalTbl();
            success(data);
        },

        onEditRow: function (datatable, rowdata, success, error) {
            const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

            for (let colDef of columInDefs) {
                if (colDef.typeof === "decimal") {
                    const value = data[colDef.data];
                    if (!check(value, colDef.title)) {
                        error(data);
                        return;
                    }
                }
            }

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

    const calTbl = $('#calTableB').DataTable({
        columns: [
            {
                data: null,
                title: '#',
                type: 'hidden',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'utilidadNeta', title: 'UTILIDAD NETA' },
            { data: 'totalEgresos', title: 'TOTAL EGRESOS' },
            { data: 'efectivoCierre', title: 'EFECTIVO AL CIERRE' },
            { data: 'ventaTarjeta', title: 'VENTA TARJETA - %' },
            { data: 'totalIngresos', title: 'TOTAL INGRESOS' },
            { data: 'utilidadPiso', title: 'UTILIDAD PISO' },
            { data: 'utilidadDisponible', title: 'UTILIDAD DISPONIBLE' },
            { data: 'total', title: 'TOTAL PLATAFORMAS' },
            { data: 'utilidadPlataforma', title: 'UTILIDAD NETA PLATAFORMA' }
        ],
        dom: 'Bfrtip',
        responsive: true,
        altEditor: false,
        language: { url: "../../JSON/es-ES.json" },
        buttons: [
            { extend: 'print', exportOptions: { columns: ':visible' } },
            'colvis'
        ]
    });
});
