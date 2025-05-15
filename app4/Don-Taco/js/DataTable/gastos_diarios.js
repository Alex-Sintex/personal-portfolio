$(document).ready(function () {

  $.getJSON('data.json', function (dataSet) {
    var myTable = $('#gastos_d').DataTable({
      data: dataSet,
      responsive: true,
      altEditor: true,
      columns: [
        { data: "Fecha" },
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
        { data: null, defaultContent: '<a class="delbutton fa fa-minus-square btn btn-danger" href="#"></a>', orderable: false }
      ],
      select: {
        selector: 'td:not(:last-child)',
        style: 'os',
        toggleable: false
      }
    });

    // Edit row
    $(document).on('click', '#gastos_d tbody', 'tr', function () {
      var that = $('#gastos_d')[0].altEditor;
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
    $(document).on('click', '#gastos_d .delbutton', function (x) {
      var that = $('#gastos_d')[0].altEditor;
      that._openDeleteModal();
      $('#altEditor-delete-form-' + that.random_id)
        .off('submit')
        .on('submit', function (e) {
          e.preventDefault();
          e.stopPropagation();
          that._deleteRow();
        });
      x.stopPropagation(); // avoid opening edit
    });

    // Add row
    $('#addbutton').on('click', function () {
      var that = $('#gastos_d')[0].altEditor;
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