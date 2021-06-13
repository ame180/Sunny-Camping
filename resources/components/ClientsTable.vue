<template>
    <div>
        <div class="row border" v-for="client in clients.data" type="button" :data-target="'#collapse-' + client.id"
             data-toggle="collapse"
             aria-expanded="false" :aria-controls="'collapse-' + client.id">
            <div class="col-12">
                <div class="row no-gutters">
                    <div class="col p-2">
                        <div class="float-sm-left">
                            <b>#{{ client.id }} {{ client.name }}</b>
                        </div>
                        <div class="float-sm-right" v-if="client.status === 'settled'">
                            <b>Rozliczono</b>
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
                <div class="collapse row border-top p-3" :id="'collapse-' + client.id">
                    <div class="col-12">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SettleModal from "./SettleModal";

export default {
    props: ['clients'],
    methods:
        {
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
                axios.delete(baseUrl + '/api/client/delete/' + id)
                    .then(() => {
                        window.location.reload()
                    });
            },
        },
    mounted() {
        axios.get(baseUrl + '/api/category/all-by-service/1')
            .then((response) => {
                this.categories = response.data;
                console.log(this.categories);
            });
    },
    data: function() {
        return {
            categories: null
        }
    }
}
</script>
