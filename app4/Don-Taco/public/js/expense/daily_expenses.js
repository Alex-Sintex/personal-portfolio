import { currencyRender, checkAllDecimalFields } from '../helper/helpers.js';

$(document).ready(function () {

  // Initialize the Toasty library
  const toast = new Toasty();

  // Declare an array of values to be added
  const keysToSum = [
    "carne", "queso", "tortilla_maiz", "tortilla_hna_gde", "longaniza",
    "pan", "vinagre", "bodegon", "adel_marcos", "trans_marcos",
    "nomina", "nomina_weekend", "mundi_novi", "color", "otros"
  ];

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

  let columDefs = [
    {
      data: null, title: "#", type: "hidden",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      }
    },
    { data: 'id', title: 'ID', visible: false, type: 'hidden' },
    { data: "date", title: "Fecha", type: "hidden" },
    { data: "carne", title: "Carne", typeof: "decimal", render: currencyRender },
    { data: "queso", title: "Queso", typeof: "decimal", render: currencyRender },
    { data: "tortilla_maiz", title: "Tortilla de Maíz", typeof: "decimal", render: currencyRender },
    { data: "tortilla_hna_gde", title: "Tortilla de harina grande", typeof: "decimal", render: currencyRender },
    { data: "longaniza", title: "Longaniza", typeof: "decimal", render: currencyRender },
    { data: "pan", title: "Pan", typeof: "decimal", render: currencyRender },
    { data: "vinagre", title: "Vinagre", typeof: "decimal", render: currencyRender },
    { data: "bodegon", title: "Bodegón", typeof: "decimal", render: currencyRender },
    { data: "adel_marcos", title: "Adelanto Marcos", typeof: "decimal", render: currencyRender },
    { data: "trans_marcos", title: "Transporte Marcos", typeof: "decimal", render: currencyRender },
    { data: "nomina", title: "Nómina", typeof: "decimal", render: currencyRender },
    { data: "nomina_weekend", title: "Nómina weekend", typeof: "decimal", render: currencyRender },
    { data: "mundi_novi", title: "Mundi Novi", typeof: "decimal", render: currencyRender },
    { data: "color", title: "Color", typeof: "decimal", render: currencyRender },
    { data: "otros", title: "Otros", typeof: "decimal", render: currencyRender },
    { data: "observaciones", title: "Observaciones", type: "textarea", typeof: "string" },
    { data: "totalGD", title: "Total Gastos Diarios", type: "readonly", render: currencyRender }
  ];

  // Initialize DataTable
  const tbl = $('#tableGD').DataTable({
    ajax: {
      url: 'gastosd/fetch',
      dataSrc: ''
    },
    columns: columDefs,
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

      if (!checkAllDecimalFields(data, columDefs, error, toast)) return;

      $.ajax({
        url: 'gastosd/insert',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (res) {
          if (res.status === 'success') {
            tbl.ajax.reload(null, false);
            toast.success(res.message);
            success(res);
          }
        },
        error: function (xhr) {
          let message = "Error en el servidor";
          if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
            console.log("⚠️ Error de validación:", message);
          }
          toast.error(message);
          error(xhr);
        }
      });
    },

    onEditRow: function (datatable, rowdata, success, error) {
      const data = typeof rowdata === "string" ? JSON.parse(rowdata) : rowdata;

      if (!checkAllDecimalFields(data, columDefs, error, toast)) return;

      $.ajax({
        url: 'gastosd/update/' + rowdata.id,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (res) {
          if (res.status === 'success') {
            tbl.ajax.reload(null, false);
            toast.success(res.message);
            success(res);
          }
        },
        error: function (xhr) {
          let message = "Error en el servidor";
          if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
            console.log("⚠️ Error de validación:", message);
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
        url: 'gastosd/delete/' + id,
        type: 'DELETE',
        success: function (res) {
          if (res.status === 'success') {
            tbl.ajax.reload(null, false);
            toast.success(res.message);
            success(res);
          }
        },
        error: function (xhr) {
          let message = "Error en el servidor";
          if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
            console.log("⚠️ Error de validación:", message);
          }
          toast.error(message);
          error(xhr);
        }
      });
    }
  });
});