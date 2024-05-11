<template>
    <div class="row border-bottom" :class="{'border-top': index === 0}" type="button" :data-target="'#collapse-' + client.id"
         data-toggle="collapse"
         aria-expanded="false" :aria-controls="'collapse-' + client.id">
        <div class="col-12">
            <div class="row no-gutters">
                <div class="col p-2">
                    <div class="row">
                        <div class="col-12 col-sm">
                            <b>{{ getClientHeader(client) }}</b>
                        </div>
                        <div class="col-12 col-sm text-left text-sm-right">
                            <b v-if="client.status === 'settled'">Rozliczono</b>
                            <b v-if="client.unregistered === 1">N</b><b v-if="client.cash_register === 1">K</b><b v-if="client.terminal === 1">T</b><b v-if="client.voucher === 1">B</b><b v-if="client.invoice === 1">F</b>
                        </div>
                    </div>
                    <div>
                        {{ client.arrival_date ? client.arrival_date : '?' }} -
                        {{ client.departure_date ? client.departure_date : '?' }}
                    </div>
                </div>
                <div class="col-3 col-sm-2 border-left">
                    <div class="row no-gutters text-center">
                        <div class="col-12 p-1">
                            <a class="btn btn-primary"
                               :href="'clients/edit/' + client.id">
                                <i class="far fa-fw fa-sticky-note"></i>
                            </a>
                        </div>
                        <form @submit.prevent="showDeleteDialog(client.id)" method="POST" action=""
                              class="col-12 p-1 m-0">
                            <button class="btn btn-danger">
                                <i class="far fa-fw fa-trash-alt"></i>
                            </button>
                        </form>
                        <div class="col-12 p-1">
                            <a @click="showSettleModal(client)"
                               class="btn btn-warning text-light">
                                <i class="fas fa-fw fa-dollar-sign"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <v-dialog></v-dialog>
            </div>
            <div class="collapse row border-top" :id="'collapse-' + client.id">
                <div class="col-12">
                    <div class="row p-3">
                        <div class="col-12 col-sm-6 col-lg-3 mb-1" v-for="category in categories">
                            <div>
                                <b>{{ category.name }}</b>
                                <div v-for="item in client.client_items"
                                     v-if="item.service_category && item.service_category.id === category.id">
                                    {{ item.count }} x {{ item.name }} {{ item.price }} zł
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2" v-if="client.car_registration || client.comment">
                            <div v-if="client.car_registration">
                                <b>Rejestracja: </b>{{ client.car_registration }}
                            </div>
                            <div v-if="client.comment">
                                <b>Komentarz: </b>{{ client.comment }}
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div>
                                <b>Suma: {{ client.price }} zł <span v-if="client.paid > 0">(zapłacono {{
                                        client.paid
                                    }} zł)</span></b>
                            </div>
                            <div>
                                <b>Klimatyczne: {{ client.climate_price }} zł <span
                                    v-if="client.climate_paid > 0">(zapłacono {{ client.climate_paid }} zł)</span></b>
                            </div>
                            <div>
                                <b>Razem: {{ client.price + client.climate_price }} zł <span
                                    v-if="client.paid + client.climate_paid> 0">(zapłacono {{
                                        client.paid + client.climate_paid
                                    }} zł)</span></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SettleModal from "./SettleModal.vue";

export default {
    props: {
        client: Object,
        index: Number,
        categories: Array
    },
    methods: {
        getClientHeader(client) {
            return '#' + client.id + ' ' + client.name + ' '
                + (client.token_number ? '[' + client.token_number + ']' : '')
                + (client.sector ? '[' + client.sector + ']' : '');
        },
        showSettleModal(client) {
            this.$modal.show(SettleModal,
                {
                    client: client,
                    categories: this.categories,
                },
                {
                    name: 'settle-modal',
                    adaptive: true,
                    reset: true,
                    focusTrap: true,
                    height: "auto",
                    width: 400
                });
        },
        showDeleteDialog(id) {
            this.$modal.show('dialog', {
                title: 'Uwaga!',
                text: 'Czy na pewno chcesz usunąć wpis #' + id + "?",
                buttons: [
                    {
                        title: 'Nie',
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                    {
                        title: 'Tak',
                        handler: () => {
                            this.deleteClient(id);
                            this.$modal.hide('dialog')
                        }
                    }
                ]
            })
        },
        deleteClient: function (id) {
            axios.delete(baseUrl + '/api/clients/' + id)
                .then(() => {
                    window.location.reload()
                });
        },
    }
}
</script>
