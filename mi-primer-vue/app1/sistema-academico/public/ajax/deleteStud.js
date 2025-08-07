$(document).ready(function () {
    $('.btn-delete').on('click', function () {
        var stud_id = $(this).attr('id'); // ID ANCHOR TAG HTML <a id="...">
        $("#deleteStud").modal('show');
        $('#btn_yes').attr('name', stud_id);
    });

    $('#btn_yes').on('click', function () {
        var stud_id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "deleteStud",
            data: {
                stud_id: stud_id
            },
            success: function (response) {
                $("#deleteStud").modal('hide');
                $(".del_stud" + stud_id).empty();
                $(".del_stud" + stud_id).html("<td colspan='6'><center class='text-danger'>Deleting...</center></td>");
                setTimeout(function () {
                    $(".del_stud" + stud_id).fadeOut('slow');
                }, 2000);

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
