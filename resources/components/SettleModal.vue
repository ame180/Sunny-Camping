<template>
    <div>
        <div class="p-2">
            <h1 class="text-center">Rozliczenie</h1>
            <b>
                #{{ data.id }} {{ data.firstName }} {{ data.lastName }}<br>
                Dni: {{ days }}<br>
                Cena za dzień: {{ pricePerDay }} zł<br>
                <span v-if="data.discount != 0">Rabat: {{ data.discount }}%<br></span>
                Suma<span v-if="data.discount != 0"> (po rabacie)</span>: {{ data.price }} zł
            </b>
        </div>
        <div class="row no-gutters">
            <div class="col p-1">
                <a @click="$modal.hide('settle-modal')" class="btn btn-outline-secondary w-100 h-100">Anuluj</a>
            </div>
            <div class="col p-1">
                <a @click="submitSettlement(); $modal.hide('settle-modal');"
                   class="btn btn-outline-secondary w-100 h-100">Rozlicz</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    created() {

    },
    methods: {
        submitSettlement() {

        }
    },
    computed: {
        days: function() {
            return (new Date(this.data.departureDate) - new Date(this.data.arrivalDate)) / (1000 * 60 * 60 * 24);
        },
        pricePerDay: function() {
            return this.data.price / this.days;
        }
    }
}
</script>
