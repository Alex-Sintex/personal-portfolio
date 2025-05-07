$(document).ready(function () {
    var defaultCharge = "<?php echo $charge; ?>"; // Get the default charge from the PHP variable

    /* Dropdown Menu */
    $('.dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);

        // Set the default option based on the PHP variable
        if (defaultCharge) {
            $(this).find('.dropdown-menu li#' + defaultCharge).click();
        }
    });

    $('.dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });

    $('.dropdown .dropdown-menu li').click(function () {
        $(this).parents('.dropdown').find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
    });
    /* End Dropdown Menu */
});