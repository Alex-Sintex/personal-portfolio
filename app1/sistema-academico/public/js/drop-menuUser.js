$(document).ready(function () {

    /* Dropdown Menu for Charge */
    $('.dropdownC').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdownC-menu').slideToggle(300);
    });

    $('.dropdownC').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownC-menu').slideUp(300);
    });

    $('.dropdownC .dropdownC-menu li').click(function () {
        var $this = $(this);
        $this.parents('.dropdownC').find('span').text($this.text());
        $this.parents('.dropdownC').find('input').attr('value', $this.attr('id'));

        if ($this.attr('id') === "Jefe de carrera") {
            // Show the div with class "showC" to pick a career
            $('.showC').show();
        } else if ($this.attr('id') === "Secretario") {
            // Show the div with class "showC" to pick a career
            $('.showC').show();
        } else {
            // Hide the div element with class "showC"
            $('.showC').hide();
        }
    });

    $('.dropdownUs').click(function () {
        //if (!isDropdownsDisabled) {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdownUs-menu').slideToggle(300);
        //}
    });

    $('.dropdownUs').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownUs-menu').slideUp(300);
    });

    // Initially hide the "showC" div
    $('.showC').hide();

    $('.dropdownUs .dropdownUs-menu li').click(function () {
        var $this = $(this);
        $this.parents('.dropdownUs').find('span').text($this.text());
        $this.parents('.dropdownUs').find('input').attr('value', $this.attr('id'));
    });
});
/*End Dropdown Menu*/