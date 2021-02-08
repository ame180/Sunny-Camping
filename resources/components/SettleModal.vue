<template>
    <div>
        <div class="p-2">
            <h1 class="text-center">Rozliczenie</h1>
            <b>
                #{{ data.id }} {{ data.firstName }} {{ data.lastName }}<br>
                Dni: {{ days }}<br>
                Cena za dzień: {{ pricePerDay }} zł<br>
                <div v-if="data.paid != 0">
                    Zapłacono: {{ data.paid ? data.paid : 0 }} zł<br>
                    Pozostało: {{ data.price - data.paid }} zł
                </div>
                <span v-if="data.discount != 0">Rabat: {{ data.discount }}%<br></span>
                Suma<span v-if="data.discount != 0"> (po rabacie)</span>: {{ data.price }} zł
            </b>
            <div class="form-group mt-2">
                <label for="settlement">Wpłacono:</label>
                <input class="form-control" name="settlement" v-model="settlement" type="number" placeholder="0">
            </div>
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
    props: {
        data: Object,
        refreshTable: Function
    },
    data() {
        return {
            settlement: this.data.paid
        }
    },
    methods: {
        submitSettlement() {
            if (!this.settlement) return;
            axios.patch(baseUrl + '/admin/clients/settle/' + this.id, {
                settlement: this.settlement
            }).then(() => {
                this.refreshTable();
            })
        }
    },
    computed: {
        days: function() {
            return (new Date(this.data.departureDate) - new Date(this.data.arrivalDate)) / (1000 * 60 * 60 * 24);
        },
        pricePerDay: function() {
            return Math.round(this.data.price / this.days * 100) / 100;
        }
    }
}
</script>
