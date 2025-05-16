$(document).ready(function () {

    $.getJSON('data2.json', function (dataSet) {
        
        let editingRowIndex = null;

        // Functions to calculate totals
        function calcularTotales(modalSelector, isEdit = false) {
            const gastosFD = parseFloat(modalSelector.find('#gastos_f_d').val().replace(/,/g, '')) || 0;
            const gastosD = parseFloat(modalSelector.find('#gastos_diarios').val().replace(/,/g, '')) || 0;
            const ventaNetaTarjeta = parseFloat(modalSelector.find('#venta_ntar').val().replace(/,/g, '')) || 0;
            const ventaEfec = parseFloat(modalSelector.find('#venta_efec').val().replace(/,/g, '')) || 0;
            const ventaTransf = parseFloat(modalSelector.find('#venta_transf').val().replace(/,/g, '')) || 0;
            const ingresoPlatfs = parseFloat(modalSelector.find('#ingreso_platfs').val().replace(/,/g, '')) || 0;

            // Total egresos
            const totalEgre = gastosFD + gastosD;
            modalSelector.find('#total_egre').val(totalEgre.toLocaleString('en-US', { minimumFractionDigits: 2 }));

            // Venta tarjeta
            const ventaTarjeta = ventaNetaTarjeta * 0.9652;
            modalSelector.find('#venta_tarjeta').val(ventaTarjeta.toLocaleString('en-US', { minimumFractionDigits: 2 }));

            // Total ingresos
            const totalIngre = ventaEfec + ventaTransf + ventaTarjeta;
            modalSelector.find('#total_ingre').val(totalIngre.toLocaleString('en-US', { minimumFractionDigits: 2 }));

            // Utilidad piso
            const utilidadP = totalIngre + ingresoPlatfs - totalEgre;
            modalSelector.find('#utilidad_p').val(utilidadP.toLocaleString('en-US', { minimumFractionDigits: 2 }));

            // Utilidad disponible
            let utilidadAnterior = 0;
            const currentIndex = isEdit ? editingRowIndex : myTable.data().count(); // Index of current editing or new record

            if (currentIndex > 0) {
                const prevRow = myTable.row(currentIndex - 1).data();
                utilidadAnterior = parseFloat((prevRow.utilidad_disp || "0").toString().replace(/,/g, ''));
            }

            const utilidadDisp = utilidadAnterior + utilidadP - gastosFD;
            modalSelector.find('#utilidad_disp').val(utilidadDisp.toLocaleString('en-US', { minimumFractionDigits: 2 }));
        }

        // Evento cuando se abre el modal de edición o adición
        $(document).on("alteditor:edit_dialog_opened alteditor:add_dialog_opened", function (e) {
            const modalSelector = $(".modal").last();
            const isEdit = e.type === "alteditor:edit_dialog_opened";

            calcularTotales(modalSelector, isEdit);

            const campos = [
                "gastos_f_d", "gastos_diarios", "venta_efec",
                "venta_transf", "venta_ntar", "ingreso_platfs"
            ];
            campos.forEach(key => {
                modalSelector.find(`#${key}`).off("input").on("input", function () {
                    calcularTotales(modalSelector, isEdit);
                });
            });
        });

        // Initialize DataTable
        var myTable = $('#balance').DataTable({
            data: dataSet,
            responsive: true,
            altEditor: true,
            columns: [
                {
                    data: null,
                    type: "readonly",
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                    disabled: true,
                    type: "hidden"
                },
                {
                    data: "fecha",
                    datetimepicker: { timepicker: false, format: "Y/m/d" }
                },
                { data: "gastos_f_d" },
                { data: "gastos_diarios" },
                {
                    data: "total_egre",
                    type: "readonly",
                    disabled: true
                },
                { data: "venta_efec" },
                { data: "venta_transf" },
                { data: "venta_ntar" },
                {
                    data: "venta_tarjeta",
                    type: "readonly",
                    disabled: true
                },
                {
                    data: "total_ingre",
                    type: "readonly",
                    disabled: true
                },
                {
                    data: "utilidad_p",
                    type: "readonly",
                    disabled: true
                },
                {
                    data: "utilidad_disp",
                    type: "readonly",
                    disabled: true
                },
                { data: "ingreso_platfs" },
                { data: "nombre" },
                {
                    data: null,
                    name: "Action",
                    render: function () {
                        return '<a class="delbutton fa fa-minus-square btn btn-danger" href="#"></a>';
                    },
                    disabled: true,
                    type: "hidden"
                }
            ],
            select: {
                selector: 'td:not(:last-child)',
                style: 'os',
                toggleable: false
            }
        });

        // Edit row
        $('#balance tbody').on('click', 'td', function () {
            const cellIndex = this.cellIndex;
            if (cellIndex === 0 || cellIndex === 17) return;

            myTable.row(this).select();

            const that = $('#balance')[0].altEditor;
            that._openEditModal();

            $('#altEditor-edit-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._editRowData();
                });
        });

        // Delete row
        $(document).on('click', '#balance .delbutton', function (x) {
            var that = $('#balance')[0].altEditor;
            that._openDeleteModal();
            $('#altEditor-delete-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._deleteRow();
                });
            x.stopPropagation();
        });

        // Add row
        $('#addbutton').on('click', function () {
            var that = $('#balance')[0].altEditor;
            that._openAddModal();
            $('#altEditor-add-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._addRowData();
                });
        });

    });
});