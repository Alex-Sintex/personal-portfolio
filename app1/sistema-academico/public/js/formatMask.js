$(document).ready(function () {
  $('.timepicker').timepicker({
    showInputs: false
  });
  $('#acta_date').inputmask({
    alias: 'dd/mm/yyyy',
    placeholder: 'dd/mm/yyyy'
  });
  $('#celebrated_at').inputmask({
    alias: 'dd/mm/yyyy',
    placeholder: 'dd/mm/yyyy'
  });
});