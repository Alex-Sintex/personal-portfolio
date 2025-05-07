$(document).ready(function () {
    // Fetch data using AJAX
    $.ajax({
        type: 'GET',
        url: 'fetchCountFDCData',
        data: { fetchData: true },
        dataType: 'json',
        success: function (data) {
            var totalRecords = 0;  // Initialize totalRecords variable

            // Loop through the fetched data and update the HTML
            $.each(data, function (index, item) {
                totalRecords += item.record_count; // Increment totalRecords

                var progressBarWidth = (item.record_count / totalRecords) * 100;
                var progressHtml = `
                        <div class="progress-group">
                            <span class="progress-text">${item.carrera}</span>
                            <span class="progress-number"><b>${item.record_count}</b></span>
                            <div class="progress sm">
                                <div class="progress-bar progress-bar-aqua" style="width: ${progressBarWidth}%"></div>
                            </div>
                        </div>`;

                // Append the HTML to your container
                $('.col-md-4').append(progressHtml);
            });
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
});