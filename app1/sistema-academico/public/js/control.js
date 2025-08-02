$(document).ready(function () {
	// DROPDOWN EDITC
	var isEditMode = false; // Track the edit mode state
	$('#careerDropdown').click(function () {
		if (isEditMode) {
			$(this).attr('tabindex', 1).focus();
			$(this).toggleClass('active');
			$(this).find('.dropdownEditC-menu').slideToggle(300);
		}
	});

	$('#careerDropdown').focusout(function () {
		if (isEditMode) {
			$(this).removeClass('active');
			$(this).find('.dropdownEditC-menu').slideUp(300);
		}
	});

	$('#careerDropdown .dropdownEditC-menu li').click(function () {
		var $this = $(this);
		var selectedId = $this.attr('id');
		var dropdownC = $('#careerDropdown');
		var inputField = dropdownC.find('input[name="career"]');
		dropdownC.find('span').text($this.text());
		inputField.val(selectedId);
	});

	// Your existing code for disabling/enabling fields based on the "Edit" button click
	var savebutton = document.getElementById('savebutton');
	var inputs = document.querySelectorAll('.uProfile');
	var inputFile = document.getElementById('fileSelect');

	// Disable the dropdown on page load
	$('.dropdownEditC .dropdownEditC-menu').hide();
	// Set style 'disabled' to the 'select' element on page load
	$('.dropdownEditC .select').addClass('disabled');

	inputFile.disabled = true;
	// Disable the radio buttons on page load
    $('input[type="radio"]').prop('disabled', true);

    // Disable the check buttons on page load
    $('input[type="checkbox"]').prop('disabled', true);

	savebutton.addEventListener('click', function () {

		isEditMode = !isEditMode;

		for (var i = 0; i < inputs.length; i++) {
			inputs[i].readOnly = !isEditMode;
		}

		inputFile.disabled = !isEditMode;

		// Toggle the disabled property of radio buttons
		var radioButtons = document.querySelectorAll('input[type="radio"]');
		for (var i = 0; i < radioButtons.length; i++) {
			radioButtons[i].disabled = !isEditMode;
		}

		// Toggle the disabled property of check buttons
		var checkButtons = document.querySelectorAll('input[type="checkbox"]');
		for (var i = 0; i < checkButtons.length; i++) {
			checkButtons[i].disabled = !isEditMode;
		}

		if (savebutton.innerHTML == "<b>Save</b>") {
			savebutton.innerHTML = "<b>Edit</b>";
			$('.dropdownEditC .select').addClass('disabled');

		} else {
			savebutton.innerHTML = "<b>Save</b>";
			$('.dropdownEditC .select').removeClass('disabled');
		}
	});
});