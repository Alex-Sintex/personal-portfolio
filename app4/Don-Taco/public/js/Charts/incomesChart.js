import { createWeeklyAreaChart } from '../Charts/chartHelpers.js';

document.addEventListener('DOMContentLoaded', async () => {
    const ctx = document.getElementById('incomesChart').getContext('2d');

    try {
        const response = await fetch('/dashboard/getWeeklyIncomes');
        const rawData = await response.json();

        if (!Array.isArray(rawData)) {
            throw new Error("Respuesta inválida del servidor");
        }

        // Filtrar y ordenar por fecha ascendente
        const finalData = rawData
            .filter(entry => !isNaN(new Date(entry.end_of_week)))
            .sort((a, b) => new Date(a.end_of_week) - new Date(b.end_of_week));

        // Formatear etiquetas tipo "22 jun"
        const labels = finalData.map(item =>
            new Date(item.end_of_week).toLocaleDateString('es-MX', {
                day: '2-digit',
                month: 'short'
            })
        );

        // Crear el área chart
        createWeeklyAreaChart(ctx, 'Ingresos Totales (por día)', {
            labels,
            data: finalData.map(item => parseFloat(item.total_income))
        }, {
            bg: 'rgba(75, 192, 192, 0.2)',
            border: 'rgba(75, 192, 192, 1)'
        });

    } catch (error) {
        console.error('Error al cargar los ingresos:', error);
    }
});