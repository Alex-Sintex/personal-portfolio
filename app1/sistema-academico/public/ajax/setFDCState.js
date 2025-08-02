$(document).ready(function () {
    $('.btn-sendFDC').on('click', function () {
        var stud_user = $(this).attr('id');
        $("#modalSendFDC").modal('show');
        $('#btn_yes').attr('name', stud_user);
    });

    $('#btn_yes').on('click', function () {
        var stud = $(this).attr('name');

        // First send notification
        $.ajax({
            type: "POST",
            url: "sendFDCNotification",
            data: {
                usernameStud: stud
            },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    iziToast.error({
                        title: 'Error',
                        message: response.message
                    });
                    return;
                }

                if (response.status === "success") {
                    iziToast.success({
                        title: 'Success',
                        message: response.message
                    });
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: response.status
                    });
                }
            },
            error: function () {
                // Handle error for sendFDCNotification
                iziToast.error({
                    title: 'Error',
                    message: response.status
                });
            }
        });

        // Second send F-DC-15 document
        $.ajax({
            type: "POST",
            url: "sendFDCStud",
            data: {
                usernameStud: stud
            },
            success: function (response) {
                $("#modalSendFDC").modal('hide');
                $(".sent").empty();
                $(".sent").html("<td colspan='13'><center class='text-danger'>Enviado, en espera de revisión...</center></td>");
                setTimeout(function () {
                    $(".sent").fadeOut('slow');
                    location.reload(); // Refresh the current page on success
                }, 10000);

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        showConfirmButton: false
                    });
                    return;
                }

                if (response.status === "success") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.status,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.status,
                });
            }
        });
    });
});
