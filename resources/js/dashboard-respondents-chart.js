import Chart from 'chart.js/auto';

let chartInstance = null;

function renderChart(canvasId, labels, values) {
    const canvas = document.getElementById(canvasId);

    if (!canvas) {
        return;
    }

    const context = canvas.getContext('2d');

    if (chartInstance) {
        chartInstance.destroy();
    }

    chartInstance = new Chart(context, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Respondents',
                data: values,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.85)',
                    'rgba(16, 185, 129, 0.85)',
                    'rgba(245, 158, 11, 0.85)',
                    'rgba(239, 68, 68, 0.85)',
                    'rgba(139, 92, 246, 0.85)',
                    'rgba(14, 165, 233, 0.85)',
                ],
                borderRadius: 12,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: (context) => ` ${context.parsed.y} respondents`,
                    },
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 11,
                        },
                    },
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#6b7280',
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.16)',
                    },
                },
            },
        },
    });
}

window.addEventListener('dashboard-respondents-chart-ready', (event) => {
    const detail = event.detail || {};

    renderChart(detail.canvasId || 'dashboard-respondents-chart', detail.labels || [], detail.values || []);
});