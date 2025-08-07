$(function () {
  const ctx = document.getElementById('barChart');

  // Function to update the chart with new data
  function updateChart() {
    // AJAX request to fetch new data
    $.ajax({
      url: 'fetchGraphData',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        // Check if data is not null and has the expected structure
        if (data && Array.isArray(data)) {
          // Extract months and amounts from the array of objects
          const months = data.map(entry => entry.monthname);
          const amounts = data.map(entry => entry.amount);

          chart.data.labels = months;
          chart.data.datasets[0].label = 'Suma total de todas las carreras';
          chart.data.datasets[0].data = amounts;
          chart.update();  // Update the chart
        } else {
          console.error('Invalid data structure:', data);
        }
      },
      error: function (error) {
        console.error('Error fetching data:', error);
      }
    });
  }

  // Spanish names for the months
  const labels = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

  // Initial chart setup
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: '',  // Initialize with empty label, will be updated dynamically
        data: [],  // Initialize with empty array, as it will be updated with AJAX response
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 54, 234, 0.2)',
          'rgba(201, 12, 321, 0.2)',
          'rgba(201, 238, 23, 0.2)',
          'rgba(201, 293, 10, 0.2)',
          'rgba(201, 99, 392, 0.2)',
          'rgba(201, 10, 11, 0.2)',
          'rgba(201, 90, 20, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 54, 234, 0.2)',
          'rgba(201, 12, 321, 0.2)',
          'rgba(201, 238, 23, 0.2)',
          'rgba(201, 293, 10, 0.2)',
          'rgba(201, 99, 392, 0.2)',
          'rgba(201, 10, 11, 0.2)',
          'rgba(201, 90, 20, 0.2)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          beginAtZero: true
        }
      },
      responsive: true,
      maintainAspectRatio: false,
    }
  });

  // Set interval to update chart every 3 seconds (adjust as needed)
  setInterval(updateChart, 3000);
});