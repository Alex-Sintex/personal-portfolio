$(document).ready(function () {

	/**
	 * Handle data information section
	 */
	$("#formUserInfo").submit(function (event) {
		event.preventDefault(); // Prevent the default form submission

		// Create a FormData object to handle file upload
		var formData = new FormData();

		// Get form data
		var firstname = $("#firstname").val();
		var flastname = $("#flastname").val();
		var slastname = $("#slastname").val();
		var email = $("#email").val();
		var current_passwd = $("#current_passwd").val();
		var new_passwd = $("#new_passwd").val();
		var confirm_passwd = $("#confirm_passwd").val();
		var gender = $("input[name='gender']:checked").val();
		var career = $("input[name='career']").val();

		if (!current_passwd) {
			// Display an error message
			showError("Para realizar cambios en tu información debes introducir tu contraseña actual");
			// Stop further processing if an empty field is found
			return;
		}

		// Create an array of form field values
		var formFields = [firstname, flastname, slastname, email];

		// Function to check if a value is empty
		function isEmpty(value) {
			return value.trim() === '';
		}

		// Iterate through the array and check for empty values
		for (var i = 0; i < formFields.length; i++) {
			if (isEmpty(formFields[i])) {
				// Display an error message
				showError("Por favor, llene los campos faltantes");
				// Stop further processing if an empty field is found
				return;
			}
		}

		// Validation checks
		var formFields2 = [firstname, flastname, slastname];

		// Function to check if a value is a valid name (letters and tilde)
		function isValidName(value) {
			// Allow letters and tilde (á, é, í, ó, ú, ü)
			var nameRegex = /^[a-zA-ZáéíóúüÁÉÍÓÚÜ\s]+$/;
			return nameRegex.test(value);
		}

		for (var i = 0; i < formFields2.length; i++) {
			if (!isValidName(formFields2[i].value)) {
				// Display an error message for invalid names
				showError("Por favor, ingrese un nombre válido sin caracteres especiales");
				// Stop further processing if an invalid name is found
				return;
			}
		}

		// Check if new_passwd is not empty before performing the password pattern check
		if (new_passwd.trim() !== "") {
			var passwdPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]).{8,}$/;

			// Check if the password pattern is not satisfied
			if (!passwdPattern.test(new_passwd)) {
				showError("Contraseña insegura, por favor intenta con otra que contenga 8 caracteres especiales y una mayúscula");
				clearField("#new_passwd"); // Clear the incorrect field
				return;
			}
		}

		var emailPattern = /^[a-zA-Z0-9._%+-]+@itsx\.edu\.mx$/;
		if (!emailPattern.test(email)) {
			showError("Por favor, introduzca una dirección de correo electrónico válida con el dominio @itsx.edu.mx");
			clearField("#email"); // Clear the incorrect field
			return;
		}
		
		/*if (!confirm_passwd) {
			showError("Por favor, confirma la nueva contraseña");
			clearField("#confirm_passwd");
			return;
		}*/

		if (new_passwd !== confirm_passwd) {
			showError("Las contraseñas no coinciden");
			clearField("#confirm_passwd"); // Clear the incorrect field
			return;
		}

		// Check if either of the radio buttons is selected
		if (!gender) {
			showError("¡Por favor, seleccione un género!");
			return;
		}

		// Prepare data for Ajax request
		if (rawImg) {
			formData.append("image_data", rawImg);
			formData.append("filename", selectedFile.name);
			formData.append("file_type", selectedFile.type);
		}
		formData.append("firstname", firstname);
		formData.append("flastname", flastname);
		formData.append("slastname", slastname);
		formData.append("email", email);
		formData.append("current_passwd", current_passwd);
		formData.append("new_passwd", new_passwd);
		formData.append("gender", gender);
		if (career) {
			formData.append("career", career);
		}

		// Send Ajax request to the server
		$.ajax({
			type: "POST",
			url: "profile",
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				console.log("Raw server response:", response); // Log the raw response
				var result = JSON.parse(response);
				// Handle the response from the server
				switch (result.status) {
					// Use SweetAlert for success message
					case "success":
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: result.message,
							showConfirmButton: false,
							timer: 1500,
							didClose: () => {
								location.reload(); // Refresh the current page on success
							}
						});
						break;
					case "error":
						// Handle AJAX error
						showError(result.message); // Get the error message from the server
						if (result.message === "La contraseña actual es incorrecta") {
							showError(result.message)
							clearField("#current_passwd"); // Clear the incorrect field
						}
						break;
					default:
						// Handle unexpected response
						showError(response);
						break;
				}
			}
		});
	});

	function showError(message) {
		// Show SweetAlert warning message
		let timerInterval;
		Swal.fire({
			position: 'center',
			icon: 'warning',
			title: message,
			showConfirmButton: false,
			timer: 5000
		});
	}

	function clearField(fieldSelector) {
		// Clear the input field by setting its value to an empty string
		$(fieldSelector).val('');
	}

	/**
	 * Image uploading section
	 */
	var $uploadCrop, rawImg, selectedFile;

	function readFile(input) {
		if (input.files && input.files[0]) {
			selectedFile = input.files[0]; // Store the selected file
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.upload-demo').addClass('ready');
				$('#cropImagePop').modal('show');
				rawImg = e.target.result;
			};
			reader.readAsDataURL(input.files[0]);
		} else {
			console.log("Sorry - your browser doesn't support the FileReader API");
		}
	}

	$uploadCrop = $('#upload-demo').croppie({
		viewport: {
			width: 160,
			height: 160,
			type: 'circle'
		},
		enforceBoundary: false,
		enableExif: true
	});

	$('#cropImagePop').on('shown.bs.modal', function () {
		$('.cr-slider-wrap').prepend('<p>Image Zoom</p>');
		$uploadCrop.croppie('bind', {
			url: rawImg
		}).then(function () {
			console.log("Selected file", selectedFile.name);
		});
	});

	$('#cropImagePop').on('hidden.bs.modal', function () {
		$('.item-img').val('');
		$('.cr-slider-wrap p').remove();
	});

	// Check allowed file format
	$('.item-img').on('change', function () {
		// Check if the selected file is an image
		if (this.files && this.files[0]) {
			var fileType = this.files[0].type;
			if (!fileType.startsWith('image/') || (fileType !== 'image/png' && fileType !== 'image/jpeg')) {
				// Show a toast message indicating that image format is invalid
				iziToast.error({
					title: 'Error',
					message: 'Solo se permiten imagenes PNG/JPG',
					position: 'topCenter'
				});
				return;
			}
			readFile(this);
		}
	});

	$(document).on('click', '.replacePhoto', function () {
		$('#cropImagePop').modal('hide');
		$('.item-img').trigger('click');
	});

	$('#cropImageBtn').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'base64',
			backgroundColor: "#000000",
			format: 'png',
			size: { width: 160, height: 160 }
		}).then(function (resp) {
			$('#item-img-output').attr('src', resp);
			$('#cropImagePop').modal('hide');
			$('.item-img').val('');
		});
	});
});