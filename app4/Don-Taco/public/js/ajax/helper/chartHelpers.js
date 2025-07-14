export function createWeeklyAreaChart(ctx, label, chartData, color) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,    // use passed labels array
            datasets: [{
                label,
                data: chartData.data,   // use passed data array
                fill: true,
                backgroundColor: color.bg,
                borderColor: color.border,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                x: { title: { display: true, text: 'Semana' } },
                y: { title: { display: true, text: 'Monto ($)' } }
            }
        }
    });
}