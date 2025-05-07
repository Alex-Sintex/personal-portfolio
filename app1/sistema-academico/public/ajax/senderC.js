$('#sender').on('keypress', function (e) {
    // Check if the pressed key is Enter (keyCode 13)
    if (e.which === 13) {
        var comment = $(this).val().trim(); // Get the comment from the input field
        if (!comment) return;

        $.ajax({
            type: "POST",
            url: "sendComment", // Change the URL to the endpoint where you handle comment posting
            data: {
                comment: comment
            },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response,
                        showConfirmButton: false
                    });
                    return;
                }

                if (response.status === "success") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Clear the input field
                    $('#sender').val('');

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while posting the comment.',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                });
            }
        });
    }
});