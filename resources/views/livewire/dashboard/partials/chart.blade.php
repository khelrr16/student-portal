<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4">
    <div class="h-[360px] w-full">
        <canvas
            id="dashboard-respondents-chart"
            data-chart-labels='@json($chartLabels)'
            data-chart-values='@json($chartValues)'
            class="w-full h-full"></canvas>
    </div>
</div>