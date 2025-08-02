import { createWeeklyAreaChart, formatDateLabel } from '../helper/chartHelpers.js';

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('incomesChart').getContext('2d');

    $.ajax({
        url: 'dashboard/getWeeklyIncomes',
        type: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        success: function (rawData) {
            if (!Array.isArray(rawData)) {
                if (rawData.status === 'no_data') {
                    showInfoMessage('incomesChart', rawData.message || 'No hay datos de ingresos disponibles.');
                } else {
                    console.error("Respuesta inválida del servidor:", rawData);
                }
                return;
            }

            // Sort by date ascending
            const sortedData = rawData.sort((a, b) =>
                a.end_of_week.localeCompare(b.end_of_week)
            );

            // Format date labels (safe from timezone bugs)
            const labels = sortedData.map(item =>
                formatDateLabel(item.end_of_week)
            );

            const data = sortedData.map(item => parseFloat(item.total_income));

            createWeeklyAreaChart(ctx, 'Ingresos Totales (por día)', {
                labels,
                data
            }, {
                bg: 'rgba(75, 192, 192, 0.2)',
                border: 'rgba(75, 192, 192, 1)'
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los ingresos:", error);
        }
    });

    function showInfoMessage(chartId, message) {
        const chartContainer = document.getElementById(chartId).parentNode;
        const info = document.createElement('div');
        info.className = 'alert alert-warning mt-3';
        info.innerText = message;
        chartContainer.appendChild(info);
    }
});
