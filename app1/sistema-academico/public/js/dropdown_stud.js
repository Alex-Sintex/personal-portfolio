$(document).ready(function () {
    var isDropdownsDisabled = true;

    /* Dropdown Menu for Career */
    $('#careerDropdown').click(function () {
        if (!isDropdownsDisabled) {
            $(this).attr('tabindex', 1).focus();
            $(this).toggleClass('active');
            $(this).find('.dropdownC-menu').slideToggle(300);
        }
    });

    $('#careerDropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownC-menu').slideUp(300);
    });

    $('#careerDropdown .dropdownC-menu li').click(function () {
        var $this = $(this);
        var selectedId = $this.attr('id');
        var dropdownC = $('#careerDropdown');
        var inputField = dropdownC.find('input[name="career"]');
        dropdownC.find('span').text($this.text());
        inputField.val(selectedId);
    });
    /* End Dropdown Menu for Career */

    /* Dropdown Menu for Charge */
    $('#chargeDropdown').click(function () {
        if (!isDropdownsDisabled) {
            $(this).attr('tabindex', 1).focus();
            $(this).toggleClass('active');
            $(this).find('.dropdownC-menu').slideToggle(300);
        }
    });

    $('#chargeDropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownC-menu').slideUp(300);
    });

    $('#chargeDropdown .dropdownC-menu li').click(function () {
        var $this = $(this);
        var selectedId = $this.attr('id');
        var dropdownC = $('#chargeDropdown');
        var inputField = dropdownC.find('input[name="charge"]');
        dropdownC.find('span').text($this.text());
        inputField.val(selectedId);
    });
    /* End Dropdown Menu for Charge */

    // Disable both dropdowns
    isDropdownsDisabled = true;
    $('#careerDropdown, #chargeDropdown').addClass('disabled');
});