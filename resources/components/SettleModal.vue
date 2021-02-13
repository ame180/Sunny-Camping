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
                    <span v-if="data.price - data.paid > 0">Pozostało: {{ data.price - data.paid }} zł</span>
                </div>
                <span v-if="data.discount != 0">Rabat: {{ data.discount }}%<br></span>
                Suma<span v-if="data.discount != 0"> (po rabacie)</span>: {{ data.price }} zł
            </b>
            <div class="form-group mt-2">
                <label for="settlement">Wpłacono:</label>
                <input class="form-control" :class="{ 'is-invalid': isInvalid }" @input="isInvalid = false" name="settlement"
                       v-model="settlement" type="number" placeholder="0">
                <div class="invalid-feedback">
                    Liczba nie może być ujemna.
                </div>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col p-1">
                <a @click="$modal.hide('settle-modal')" class="btn btn-outline-secondary w-100 h-100">Anuluj</a>
            </div>
            <div class="col p-1">
                <a @click="submitSettlement()"
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
            settlement: null,
            isInvalid: false
        }
    },
    methods: {
        submitSettlement() {
            if (!this.settlement) return;
            if (this.settlement <= 0) {
                this.isInvalid = true;
                return;
            }
            axios.patch(baseUrl + '/admin/clients/settle/' + this.data.id, {
                settlement: this.settlement
            }).then(() => {
                this.refreshTable();
                this.$modal.hide('settle-modal');
            }, () => {
                alert("Coś poszło nie tak! Czy wpisane dane są poprawne?");
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
