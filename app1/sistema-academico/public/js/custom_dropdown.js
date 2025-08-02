/*Dropdown Menu*/
$('.dropdownC').click(function () {
    $(this).attr('tabindex', 1).focus();
    $(this).toggleClass('active');
    $(this).find('.dropdown-menuC').slideToggle(300);
});

$('.dropdownC').focusout(function () {
    $(this).removeClass('active');
    $(this).find('.dropdown-menuC').slideUp(300);
});

$('.dropdownC .dropdown-menuC .career').click(function () {
    $(this).parents('.dropdownC').find('#selected_career').text($(this).text());
    $(this).parents('.dropdownC').find('input').attr('value', $(this).attr('id'));
});
/*End Dropdown Menu*/