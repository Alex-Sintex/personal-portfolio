// Date format input
$(document).ready(function () {
    $('#fechaFDC').inputmask('dd/mm/yyyy');
});

$(function () {
    //Initialize Inputmask for elements with data-mask attribute
    $('[data-mask]').inputmask()
})