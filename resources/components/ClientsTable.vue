<template>
    <div>
        <form class="d-flex justify-content-end" method="get" action="">
            <div class="form-inline mb-2">
                <div class="form-check-inline">
                    <input name="unregistered" v-model="filters.unregistered" type="checkbox"
                           class="form-check-input m-1" value="true">
                    <label for="unregistered" class="form-check-label">N</label>
                </div>
                <div class="form-check-inline">
                    <input name="cash_register" v-model="filters.cash_register" type="checkbox"
                           class="form-check-input m-1" value="true">
                    <label for="cash_register" class="form-check-label">K</label>
                </div>
                <div class="form-check-inline">
                    <input name="terminal" v-model="filters.terminal" type="checkbox"
                           class="form-check-input m-1" value="true">
                    <label for="terminal" class="form-check-label">T</label>
                </div>
                <div class="form-check-inline">
                    <input name="voucher" v-model="filters.voucher" type="checkbox"
                           class="form-check-input m-1" value="true">
                    <label for="voucher" class="form-check-label">B</label>
                </div>
                <div class="form-check-inline">
                    <input name="invoice" v-model="filters.invoice" type="checkbox"
                           class="form-check-input m-1" value="true">
                    <label for="invoice" class="form-check-label">F</label>
                </div>
                <input v-model="filters.departure_date" name="departure_date" type="date"
                       class="form-control form-control-sm m-1" placeholder="Data odjazdu">
                <select v-model="filters.status" name="status" type="select"
                        class="form-control form-control-sm m-1">
                    <option value="">Wszystkie</option>
                    <option value="unsettled">Nierozliczono</option>
                    <option value="settled">Rozliczono</option>
                </select>
                <select v-model="filters.token_number" name="token_number" type="select"
                        class="form-control form-control-sm m-1">
                    <option value="">Wszystkie</option>
                    <option v-for="tokenNumber in assignedTokens" :value="tokenNumber">{{ tokenNumber }}</option>
                </select>
                <input v-model="filters.query" type="text" class="form-control form-control-sm m-1" name="query"
                       list="client-names" placeholder="Szukaj">
                <datalist id="client-names">
                    <option v-for="name in clientNames" :value="name">{{ name }}</option>
                </datalist>
                <button type="submit" class="btn btn-primary btn-sm m-1">Szukaj</button>
            </div>
        </form>
        <clients-table-row
            v-for="(client, index) in clients.data"
            :client="client"
            :index="index"
            :categories="categories"
            v-bind:key="client.id"
        ></clients-table-row>
        <v-dialog></v-dialog>
    </div>
</template>

<script>
import ClientsTableRow from "./ClientsTableRow.vue";

export default {
    components: {ClientsTableRow},
    props: ['clients', 'filters', 'clientNames', 'assignedTokens', 'page', 'totalClientCount'],
    methods:
        {
            groupItems(client) {
                let items = client.client_items;
                for (let i = 0; i < items.length; i++) {
                    for (let j = i + 1; j < items.length; j++) {
                        if (items[i].name === items[j].name && items[i].price === items[j].price) {
                            items[i].count += items[j].count;
                            items.splice(j, 1);
                            j--;
                        }
                    }
                }
            },
        },
    mounted() {
        axios.get(baseUrl + '/api/categories?service_id=1')
            .then((response) => {
                this.categories = response.data;
            });
        this.clients.data.forEach(function (client) {
            this.groupItems(client)
        }, this);
    },
    data: function () {
        return {
            categories: null,
        }
    }
}
</script>
