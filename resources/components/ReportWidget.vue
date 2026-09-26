<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ title }}</h3>
        </div>
        <div class="card-body">
            <div v-if="failed" class="text-danger">Nie udało się wczytać danych.</div>
            <div v-else-if="loaded && series.length === 0" class="text-muted">Brak danych za {{ year }}.</div>
            <template v-else-if="loaded">
                <div class="mb-3">
                    <div class="text-muted small">{{ totalLabel }}</div>
                    <div class="report-total">{{ formattedTotal }}</div>
                </div>
                <div class="mb-3">
                    <button
                        v-for="row in series"
                        :key="row.key"
                        type="button"
                        class="btn btn-sm btn-light border me-1 mb-1 report-chip"
                        :class="{ 'report-chip-off': !selectedKeys.includes(row.key) }"
                        :aria-pressed="selectedKeys.includes(row.key) ? 'true' : 'false'"
                        @click="toggle(row.key)"
                    >
                        <span class="report-swatch" :style="{ backgroundColor: colors[row.key] }"></span>
                        {{ row.label }}
                    </button>
                    <button v-if="!allSelected" type="button" class="btn btn-sm btn-link mb-1" @click="selectAll">
                        Wszystkie
                    </button>
                </div>
                <stacked-monthly-chart :series="visibleSeries" :colors="colors" :unit="unit"></stacked-monthly-chart>
            </template>
        </div>
    </div>
</template>

<script>
import StackedMonthlyChart from './StackedMonthlyChart.vue';
import { formatReportValue, SERIES_COLORS } from '../js/utils/reportFormat';

export default {
    components: { StackedMonthlyChart },
    props: {
        title: {
            type: String,
            required: true
        },
        endpoint: {
            type: String,
            required: true
        },
        year: {
            type: Number,
            required: true
        },
        unit: {
            type: String,
            default: 'currency'
        }
    },
    data() {
        return {
            series: [],
            selectedKeys: [],
            loaded: false,
            failed: false
        };
    },
    computed: {
        colors() {
            return Object.fromEntries(this.series.map((row, index) => [row.key, SERIES_COLORS[index % SERIES_COLORS.length]]));
        },
        visibleSeries() {
            return this.series.filter((row) => this.selectedKeys.includes(row.key));
        },
        allSelected() {
            return this.selectedKeys.length === this.series.length;
        },
        total() {
            return this.visibleSeries.reduce((sum, row) => sum + row.values.reduce((rowSum, value) => rowSum + value, 0), 0);
        },
        formattedTotal() {
            return formatReportValue(this.total, this.unit);
        },
        totalLabel() {
            if (this.visibleSeries.length === 1) {
                return `${this.visibleSeries[0].label} — ${this.year}`;
            }

            return `Razem ${this.year}`;
        }
    },
    watch: {
        year: {
            immediate: true,
            handler() {
                this.fetchReport();
            }
        }
    },
    methods: {
        fetchReport() {
            const requestedYear = this.year;
            this.failed = false;
            axios.get(baseUrl + this.endpoint, { params: { year: requestedYear } })
                .then(({ data }) => {
                    if (requestedYear !== this.year) {
                        return;
                    }

                    const keys = data.series.map((row) => row.key);
                    const keptKeys = this.allSelected ? [] : this.selectedKeys.filter((key) => keys.includes(key));

                    this.series = data.series;
                    this.selectedKeys = keptKeys.length > 0 ? keptKeys : keys;
                    this.loaded = true;
                })
                .catch(() => {
                    if (requestedYear !== this.year) {
                        return;
                    }

                    this.failed = true;
                });
        },
        toggle(key) {
            if (this.allSelected) {
                this.selectedKeys = [key];
                return;
            }

            if (!this.selectedKeys.includes(key)) {
                this.selectedKeys = [...this.selectedKeys, key];
                return;
            }

            const remainingKeys = this.selectedKeys.filter((selectedKey) => selectedKey !== key);
            this.selectedKeys = remainingKeys.length > 0 ? remainingKeys : this.series.map((row) => row.key);
        },
        selectAll() {
            this.selectedKeys = this.series.map((row) => row.key);
        }
    }
}
</script>

<style scoped>
.report-total {
    font-size: 1.75rem;
    font-weight: 600;
}

.report-chip-off {
    opacity: .45;
}

.report-swatch {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 2px;
    margin-right: 4px;
}
</style>
