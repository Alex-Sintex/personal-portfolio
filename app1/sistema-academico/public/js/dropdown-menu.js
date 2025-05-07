$(document).ready(function () {
    /*Dropdown Menu*/
    $('.dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });

    $('.dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });

    // Initially hide the "showC" div
    $('.showC').hide();

    $('.dropdown .dropdown-menu li').click(function () {
        var $this = $(this);
        $this.parents('.dropdown').find('span').text($this.text());
        $this.parents('.dropdown').find('input').attr('value', $this.attr('id'));

        if ($this.attr('id') === "Jefaturas de carrera") {
            $('.showC').show(); // Show the div with class "showC"
        } else if ($this.attr('id') === "Secretario") {
            $('.showC').show(); // Show the div with class "showC"
        } else {
            console.log("Selected value: " + $this.attr('id'));
            $('.showC').hide(); // Hide the div with class "showC"
        }
    });
    /*End Dropdown Menu*/
});