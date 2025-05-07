$(document).ready(function () {

    /* Dropdown Menu for Charge */
    $('.dropdownEditU').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdownEditU-menu').slideToggle(300);
    });

    $('.dropdownEditU').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownEditU-menu').slideUp(300);
    });

    $('.dropdownEditU .dropdownEditU-menu li').click(function () {
        var $this = $(this);
        $this.parents('.dropdownEditU').find('span').text($this.text());
        $this.parents('.dropdownEditU').find('input').attr('value', $this.attr('id'));

        if ($this.attr('id') === "Jefe de carrera") {
            // Show the div with class "showEditC" to pick a career
            $('.showEditC').show();
        } else if ($this.attr('id') === "Secretario") {
            // Show the div with class "showEditC" to pick a career
            $('.showEditC').show();
        } else {
            // Hide the div element with class "showEditC"
            $('.showEditC').hide();
        }
    });

    // DROPDOWN EDITC
    $('.dropdownEditC').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdownEditC-menu').slideToggle(300);
    });

    $('.dropdownEditC').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdownEditC-menu').slideUp(300);
    });

    // Initially hide the "showEditC" div
    $('.showEditC').hide();

    $('.dropdownEditC .dropdownEditC-menu li').click(function () {
        var $this = $(this);
        $this.parents('.dropdownEditC').find('span').text($this.text());
        $this.parents('.dropdownEditC').find('input').attr('value', $this.attr('id'));
    });
});
/*End Dropdown Menu*/