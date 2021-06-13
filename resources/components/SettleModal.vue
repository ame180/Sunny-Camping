<template>
    <div>
        <div class="p-2">
            <h1 class="text-center">Rozliczenie</h1>
            <b>
                #{{ client.id }} {{ client.name }}<br>
                Dni: {{ client.days }}<br>
            </b>
            <div v-for="category in categories">
                <div>
                    <b>{{ category.name }}</b>
                    <div v-for="item in client.client_items"
                         v-if="item.service_category && item.service_category.name === category.name">
                        {{ item.count }} x {{ item.name }} {{ item.price }} zł
                    </div>
                </div>
            </div>
            <div>
                <b>Suma: {{ client.price }} zł <span v-if="client.paid > 0">(zapłacono {{ client.paid }} zł)</span></b>
            </div>
            <div>
                <b>Klimatyczne: {{ client.climate_price }} zł <span v-if="client.climate_paid > 0">(zapłacono {{ client.climate_paid }} zł)</span></b>
            </div>
            <div>
                <b>Razem: {{ client.price + client.climate_price }} zł <span v-if="client.paid + client.climate_paid> 0">(zapłacono {{ client.paid + client.climate_paid }} zł)</span></b>
            </div>
            <div class="form-group mt-2">
                <label for="settlement">Wpłata:</label>
                <input id="settlement" class="form-control" @input="isInvalid = false" name="settlement"
                       v-model="settlement" type="number" placeholder="0">
            </div>
            <div class="form-group mt-2">
                <label for="climateSettlement">Klimatyczne:</label>
                <input id="climateSettlement" class="form-control" @input="isInvalid = false" name="settlement"
                       v-model="climateSettlement" type="number" placeholder="0">
            </div>
            <div class="invalid-feedback" :class="isInvalid ? 'd-block' : 'd-none'">
                Jedna z liczb musi być większa od 0.
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
        client: Object,
        categories: Array,
    },
    data() {
        return {
            settlement: null,
            climateSettlement: null,
            isInvalid: false
        }
    },
    methods: {
        submitSettlement() {
            if (this.settlement <= 0 && this.climateSettlement <= 0) {
                this.isInvalid = true;
                return;
            }
            axios.patch(baseUrl + '/api/client/settle/' + this.client.id, {
                settlement: this.settlement ?? 0,
                climate_settlement: this.climateSettlement ?? 0
            }).then(() => {
                window.location.reload();
                this.$modal.hide('settle-modal');
            }, () => {
                alert("Coś poszło nie tak! Czy wpisane dane są poprawne?");
            })
        }
    },
}
</script>
