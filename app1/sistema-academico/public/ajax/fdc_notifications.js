// Function to fetch and update notifications
function updateNotifications() {
    $.ajax({
        url: 'getFDCNotifications',
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            // Clear existing notifications
            $('#notificationsList').empty();

            // Check if notifications are present in the response
            if (data && data.status === 'success' && data.notifications) {
                var notificationCount = data.notifications.length;

                // Update the notification count in the dropdown
                $('.label-warning').text(notificationCount);

                // Update the header message based on the number of notifications
                var headerMessage = (notificationCount === 1) ? 'You have 1 notification' : 'You have ' + notificationCount + ' notifications';
                $('.header').text(headerMessage);

                // Iterate through fetched data and append notifications

                data.notifications.forEach(function (notification) {
                    var listItem = $('<li>').append(
                        $('<a>').attr('href', 'index.html#').append(
                            $('<i>').addClass('fa fa-exclamation-triangle text-yellow').attr('aria-hidden', 'true').css('position', 'absolute'),
                            $('<small>').addClass('pull-right').text(notification.formattedDate),
                            $('<h3>').addClass('fontActa').text(notification.message),
                            $('<span>').addClass('userNotif').text(notification.nControl)
                        )
                    );

                    // Append the new notification
                    $('#notificationsList').append(listItem);
                });

            } else {
                // Display a message when no notifications are present
                $('.label-warning').text('0'); // Update the notification count to 0
                $('.header').text('No notifications');
            }
        },
        error: function (xhr, status, error) {}
    });
}

// Fetch and update notifications every second
setInterval(updateNotifications, 1000);

// Initial fetch on page load
updateNotifications();