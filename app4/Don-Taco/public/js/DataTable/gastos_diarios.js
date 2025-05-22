$(document).ready(function () {
  $.getJSON('../../json/data.json', function (dataSet) {

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

    const keysToSum = [
      "carne", "queso", "tortilla_maiz", "tortilla_h_gde", "longaniza",
      "pan", "bodegon", "adel_marcos", "trans_marcos", "nomina",
      "nomina_weekend", "mundo_novi", "color", "otros"
    ];

    // Add totalGD initially
    dataSet.forEach(function (row) {
      let total = 0;
      keysToSum.forEach(key => {
        total += parseFloat(row[key] || 0);
      });
      row.totalGD = total.toFixed(2);
    });

    // Recalculate totalGD on input in modal
    function recalculateTotalGD(modalSelector) {
      let total = 0;
      keysToSum.forEach(key => {
        const value = parseFloat($(modalSelector).find(`#${key}`).val()) || 0;
        total += value;
      });
      $(modalSelector).find(`#totalGD`).val(total.toFixed(2));
    }

    // Watch for altEditor modals opening
    $(document).on("alteditor:edit_dialog_opened alteditor:add_dialog_opened", function () {
      const modalSelector = $(".modal").last(); // Most recent modal
      keysToSum.forEach(key => {
        modalSelector.find(`#${key}`).off("input").on("input", function () {
          recalculateTotalGD(modalSelector);
        });
      });
    });

    // Initialize DataTable
    var myTable = $('#tableGD').DataTable({
      data: dataSet,
      responsive: true,
      altEditor: true,
      columns: [
        {
          data: null,
          title: "No.",
          type: "readonly",
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
          disabled: true,
          type: "hidden"
        },
        {
          data: "Fecha",
          title: "Fecha",
          datetimepicker: { timepicker: false, format: "Y/m/d" }
        },
        { data: "carne" },
        { data: "queso" },
        { data: "tortilla_maiz" },
        { data: "tortilla_h_gde" },
        { data: "longaniza" },
        { data: "pan" },
        { data: "bodegon" },
        { data: "adel_marcos" },
        { data: "trans_marcos" },
        { data: "nomina" },
        { data: "nomina_weekend" },
        { data: "mundo_novi" },
        { data: "color" },
        { data: "otros" },
        { data: "observaciones" },
        {
          data: "totalGD",
          title: "Total Gastos Diarios",
          type: "readonly"
        },
        {
          data: null,
          title: "Acción",
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
    $('#tableGD tbody').on('click', 'td', function () {
      const cellIndex = this.cellIndex;
      if (cellIndex === 0 || cellIndex === 17) return;

      myTable.row(this).select();

      const that = $('#tableGD')[0].altEditor;
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
    $(document).on('click', '#tableGD .delbutton', function (x) {
      var that = $('#tableGD')[0].altEditor;
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
      var that = $('#tableGD')[0].altEditor;
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