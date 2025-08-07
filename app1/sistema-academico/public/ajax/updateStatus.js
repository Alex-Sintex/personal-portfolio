$(document).ready(function () {
    $("#Active, #Inactive").click(function () {
        var status = $(this).attr("id"); // Get the status from the clicked element

        $.ajax({
            type: "POST",
            url: "updateStatus.php",
            data: { status: status },
            success: function (response) {
                // Update the button text with the new status
                $(".btn-primary").text(response);
            },
            error: function () {
                alert("Error updating status");
            }
        });
    });
});