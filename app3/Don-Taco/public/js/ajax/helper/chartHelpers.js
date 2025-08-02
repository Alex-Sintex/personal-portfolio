export function createWeeklyAreaChart(ctx, label, chartData, color) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label,
                data: chartData.data,
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

// ✅ Reusable date formatter: "2025-07-22" → "22-jul"
export function formatDateLabel(dateStr) {
    const [year, month, day] = dateStr.split('-').map(Number);
    const months = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    return `${day.toString().padStart(2, '0')}-${months[month - 1]}`;
}
