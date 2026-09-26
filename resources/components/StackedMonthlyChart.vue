<template>
    <div class="stacked-monthly-chart">
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script>
import { BarController, BarElement, CategoryScale, Chart, LinearScale, Tooltip } from 'chart.js';
import { formatReportAxisValue, formatReportValue } from '../js/utils/reportFormat';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip);

const monthFormat = new Intl.DateTimeFormat('pl-PL', { month: 'short' });
const MONTH_LABELS = Array.from({ length: 12 }, (_, month) => monthFormat.format(new Date(2000, month, 1)));

export default {
    props: {
        series: {
            type: Array,
            required: true
        },
        colors: {
            type: Object,
            required: true
        },
        unit: {
            type: String,
            default: 'currency'
        },
        firstMonth: {
            type: Number,
            default: 0
        },
        lastMonth: {
            type: Number,
            default: 11
        }
    },
    computed: {
        labels() {
            return MONTH_LABELS.slice(this.firstMonth, this.lastMonth + 1);
        }
    },
    watch: {
        series() {
            this.refresh();
        },
        firstMonth() {
            this.refresh();
        },
        lastMonth() {
            this.refresh();
        }
    },
    mounted() {
        this.chart = new Chart(this.$refs.canvas, {
            type: 'bar',
            data: {
                labels: this.labels,
                datasets: this.datasets()
            },
            options: {
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.dataset.label}: ${this.format(context.parsed.y)}`,
                            footer: (items) => `Razem: ${this.format(items.reduce((sum, item) => sum + item.parsed.y, 0))}`
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { color: '#898781' }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: { color: '#e1e0d9' },
                        border: { display: false },
                        ticks: { color: '#898781', precision: 0, callback: (value) => formatReportAxisValue(value, this.unit) }
                    }
                }
            }
        });
    },
    beforeUnmount() {
        this.chart.destroy();
    },
    methods: {
        refresh() {
            this.chart.data.labels = this.labels;
            this.chart.data.datasets = this.datasets();
            this.chart.update();
        },
        datasets() {
            return this.series.map((row) => ({
                label: row.label,
                data: row.values.slice(this.firstMonth, this.lastMonth + 1),
                backgroundColor: this.colors[row.key],
                borderColor: '#ffffff',
                borderWidth: { top: 2 },
                borderSkipped: 'start',
                maxBarThickness: 48
            }));
        },
        format(value) {
            return formatReportValue(value, this.unit);
        }
    }
}
</script>

<style scoped>
.stacked-monthly-chart {
    position: relative;
    height: 280px;
}
</style>
