function fetchComments() {
    $.ajax({
        type: "POST",
        url: "fetchComments", // Update the URL to match your actual endpoint
        data: {}, // You can pass additional data if needed
        success: function (response) {
            // Process the fetched comments and update the UI
            updateCommentsUI(response);
        },
        error: function (xhr, status, error) {
            // Log the error details to the console
            console.error("An error occurred while fetching comments.");
            console.error("Status:", status);
            console.error("Error:", error);
        },
        complete: function () {
            // Schedule the next fetch after 1 second
            setTimeout(fetchComments, 1000);
        }
    });
}

// Start fetching comments when the page loads
fetchComments();

// Variable to store the last timestamp
var lastTimestamp = null;

function updateCommentsUI(comments) {
    // Assuming there's an existing ul element with the class 'timeline'
    var timelineList = $('.timeline');

    // Iterate through fetched comments and append them to the timeline list
    for (var i = 0; i < comments.length; i++) {
        var commentTimestamp = comments[i].comment_date; // Assuming this is a timestamp

        // Check if the comment is newer than the last one
        if (lastTimestamp === null || commentTimestamp > lastTimestamp) {
            // Update the last timestamp
            lastTimestamp = commentTimestamp;

            // Append the date label
            var dateLabel = '<li class="time-label">' +
                '<span class="bg-red">' +
                formatDate(commentTimestamp) +
                '</span>' +
                '</li>';

            // Append the date label to the timelineList
            timelineList.append(dateLabel);

            // Append the commentItem to the timelineList
            var commentItem = '<li>' +
                '<i class="fa fa-user text-blue"></i>' +
                '<div class="timeline-item">' +
                '<span class="time"><i class="fa fa-clock-o"></i> ' + formatTime(commentTimestamp) + '</span>' +
                '<h3 class="timeline-header"><a href="javascript:void(0)">' + comments[i].firstname + '</a></h3>' +
                '<div class="timeline-body">' + comments[i].comment + '</div>' +
                '</div>' +
                '</li>';

            // Append the commentItem to the timelineList
            timelineList.append(commentItem);
        }
    }
}

function formatTime(timestamp) {
    // Format time (e.g., 24-hour format without seconds)
    var date = new Date(timestamp);
    var hours = date.getHours();
    var minutes = date.getMinutes();
    return hours + ':' + (minutes < 10 ? '0' : '') + minutes;
}

function formatDate(timestamp) {
    // Format the date
    var date = new Date(timestamp);
    var day = date.getDate();
    var month = date.toLocaleString('default', { month: 'short' });
    var year = date.getFullYear();
    return day + ' ' + month + ' ' + year;
}

// Start fetching comments when the page loads
fetchComments();