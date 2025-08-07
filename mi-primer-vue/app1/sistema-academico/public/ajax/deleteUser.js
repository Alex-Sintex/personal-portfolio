$(document).ready(function () {
    $('.btn-delete').on('click', function () {
        var user_id = $(this).attr('id');
        $("#deleteUser").modal('show');
        $('#btn_yes').attr('name', user_id);
    });

    $('#btn_yes').on('click', function () {
        var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "delete",
            data: {
                id: id
            },
            success: function (response) {
                $("#deleteUser").modal('hide');
                $(".del_user" + id).empty();
                $(".del_user" + id).html("<td colspan='6'><center class='text-danger'>Deleting...</center></td>");
                setTimeout(function () {
                    $(".del_user" + id).fadeOut('slow');
                }, 2000);

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the record.',
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
    });
});
