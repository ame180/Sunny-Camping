<template>
    <div>
        <div class="d-flex align-items-center mb-3">
            <h1 class="h3 mb-0 mr-3">Raporty</h1>
            <label for="report-year" class="sr-only">Rok</label>
            <select id="report-year" v-model.number="year" class="form-control form-control-sm w-auto">
                <option v-for="availableYear in years" :key="availableYear" :value="availableYear">{{ availableYear }}</option>
            </select>
        </div>
        <report-widget title="Przychód wg kategorii" endpoint="/api/reports/revenue" :year="year" unit="currency"></report-widget>
        <report-widget title="Płatności wg rodzaju" endpoint="/api/reports/payments" :year="year" unit="currency"></report-widget>
    </div>
</template>

<script>
import ReportWidget from './ReportWidget.vue';

const CURRENT_YEAR = new Date().getFullYear();

export default {
    components: { ReportWidget },
    data() {
        return {
            year: CURRENT_YEAR,
            years: [CURRENT_YEAR]
        };
    },
    mounted() {
        axios.get(baseUrl + '/api/reports/years')
            .then(({ data }) => {
                this.years = [...new Set([CURRENT_YEAR, ...data])].sort((first, second) => second - first);
            });
    }
}
</script>
