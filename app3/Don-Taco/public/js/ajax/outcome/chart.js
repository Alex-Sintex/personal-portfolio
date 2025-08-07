import { createWeeklyAreaChart, formatDateLabel } from '../helper/chartHelpers.js';

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('outcomesChart').getContext('2d');

    $.ajax({
        url: 'dashboard/getWeeklyExpenses',
        type: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        success: function (rawData) {
            if (!Array.isArray(rawData)) {
                if (rawData.status === 'no_data') {
                    showInfoMessage('outcomesChart', rawData.message || 'No hay datos de gastos disponibles.');
                } else {
                    console.error("Respuesta inválida del servidor:", rawData);
                }
                return;
            }

            const sortedData = rawData.sort((a, b) =>
                a.end_of_week.localeCompare(b.end_of_week)
            );

            const labels = sortedData.map(item => formatDateLabel(item.end_of_week));

            const data = sortedData.map(item => parseFloat(item.total_expense));

            createWeeklyAreaChart(ctx, 'Gastos Totales Semanales', {
                labels,
                data
            }, {
                bg: 'rgba(255, 99, 132, 0.2)',
                border: 'rgba(255, 99, 132, 1)'
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los gastos:", error);
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
