$(document).ready(function () {

    // Initialize the Toasty library
    var toast = new Toasty(options);

    var options = {
        classname: "toast",
        transition: "pinItUp",
        insertBefore: true,
        duration: 4000,
        enableSounds: true,
        autoClose: true,
        progressBar: false,
        sounds: {
            // path to sound for informational message:
            info: "../Toasty/sounds/info/1.mp3",
            // path to sound for successfull message:
            success: "../Toasty/sounds/success/1.mp3",
            // path to sound for warn message:
            warning: "../Toasty/sounds/warning/1.mp3",
            // path to sound for error message:
            error: "../Toasty/sounds/error/1.mp3",
        },
    };

    // configure the plugin after be instantiated:
    toast.configure(options);

    $.getJSON('../../json/data2.json', function (dataSet) {

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
        var myTable = $('#tableB').DataTable({
            "bPaginate": true,
            "bFilter": true,
            "bInfo": false,
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
        $('#tableB tbody').on('click', 'td', function () {
            const cellIndex = this.cellIndex;
            if (cellIndex === 0 || cellIndex === 17) return;

            myTable.row(this).select();

            const that = $('#tableB')[0].altEditor;
            that._openEditModal();

            $('#altEditor-edit-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._editRowData();
                    // show a successful message:
                    toast.success("¡Registro actualizado!");
                });
        });

        // Delete row
        $(document).on('click', '#tableB .delbutton', function (x) {
            var that = $('#tableB')[0].altEditor;
            that._openDeleteModal();
            $('#altEditor-delete-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._deleteRow();
                    // show a successful message:
                    toast.success("¡Registro eliminado!");
                });
            x.stopPropagation();
        });

        // Add row
        $('#addbutton').on('click', function () {
            var that = $('#tableB')[0].altEditor;
            that._openAddModal();
            $('#altEditor-add-form-' + that.random_id)
                .off('submit')
                .on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    that._addRowData();
                    // show a successful message:
                    toast.success("¡Registro añadido!");
                });
        });

    });
});