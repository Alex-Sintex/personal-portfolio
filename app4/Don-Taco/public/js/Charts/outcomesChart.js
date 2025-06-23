import { createWeeklyAreaChart } from '../Charts/chartHelpers.js';

document.addEventListener('DOMContentLoaded', async () => {
    const ctx = document.getElementById('outcomesChart').getContext('2d');

    try {
        const response = await fetch('/dashboard/getWeeklyExpenses');
        const rawData = await response.json();

        if (!Array.isArray(rawData)) {
            throw new Error("Respuesta inválida del servidor");
        }

        // Sort data by end_of_week ascending
        const sortedData = rawData.sort((a, b) => new Date(a.end_of_week) - new Date(b.end_of_week));

        // Create labels like "Day, Month"
        const labels = sortedData.map(item =>
            new Date(item.end_of_week).toLocaleDateString('es-MX', {
                day: '2-digit',
                month: 'short'
            })
        );

        // Data array (numbers)
        const data = sortedData.map(item => parseFloat(item.total_expense));

        // Create the area chart
        createWeeklyAreaChart(ctx, 'Gastos Totales Semanales', {
            labels,
            data
        }, {
            bg: 'rgba(255, 99, 132, 0.2)',  // red-ish transparent bg
            border: 'rgba(255, 99, 132, 1)' // red border line
        });

    } catch (error) {
        console.error('Error al cargar los gastos:', error);
    }
});