<template>
    <div class="row border" :class="{'border-top-0': index !== 0}" type="button" :data-bs-target="'#collapse-' + client.id"
         data-bs-toggle="collapse"
         aria-expanded="false" :aria-controls="'collapse-' + client.id">
        <div class="col-12">
            <div class="row g-0">
                <div class="col p-2">
                    <div class="row">
                        <div class="col-12 col-sm">
                            <b>{{ getClientHeader(client) }}</b>
                        </div>
                        <div class="col-12 col-sm text-start text-sm-end">
                            <b v-if="client.status === 'settled'">Rozliczono</b> <b v-if="client.unregistered === 1">N</b><b v-if="client.cash_register === 1">K</b><b v-if="client.terminal === 1">T</b><b v-if="client.voucher === 1">B</b><b v-if="client.invoice === 1">F</b>
                        </div>
                    </div>
                    <div v-if="client.postcode || client.country">
                        {{ [client.postcode, client.country].filter(Boolean).join(', ') }}
                    </div>
                    <div>
                        {{ client.arrival_date ? client.arrival_date : '?' }} -
                        {{ client.departure_date ? client.departure_date : '?' }}
                    </div>
                </div>
                <div class="col-3 col-sm-2 border-start d-flex flex-column justify-content-center">
                    <div class="row g-0 text-center">
                        <div class="col-12 p-1">
                            <a class="btn btn-primary"
                               :href="editHref">
                                <i class="far fa-fw fa-note-sticky"></i>
                            </a>
                        </div>
                        <form @submit.prevent="showDeleteDialog(client.id)" method="POST" action=""
                              class="col-12 p-1 m-0">
                            <button class="btn btn-danger">
                                <i class="far fa-fw fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="collapse row border-top" :id="'collapse-' + client.id">
                <div class="col-12">
                    <div class="row p-3">
                        <div class="col-12 col-sm-6 col-lg-3 mb-1" v-for="category in categories">
                            <div>
                                <b>{{ category.name }}</b>
                                <template v-for="item in client.client_items">
                                    <div v-if="item.service_category && item.service_category.id === category.id">
                                        {{ item.count }} x {{ item.name }} {{ item.price }} zł
                                    </div>
                                </template>
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
                                <b>Suma: {{ client.price }} zł <span v-if="client.paid > 0">
                                    (pozostało {{ Math.max(0, client.price - client.paid) }} zł)
                                </span></b>
                            </div>
                            <div>
                                <b>Klimatyczne: {{ client.climate_price }} zł <span v-if="client.climate_paid > 0">
                                    (pozostało {{ Math.max(0, client.climate_price - client.climate_paid) }} zł)
                                </span></b>
                            </div>
                            <div>
                                <b>Razem: {{ client.price + client.climate_price }} zł <span v-if="client.paid + client.climate_paid> 0">
                                    (pozostało {{ Math.max(0, client.price + client.climate_price - client.paid - client.climate_paid) }} zł)
                                </span></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { appendQueryParamsToPath, parseQueryParamsFromSearch } from "../js/utils/clientsQuery";

export default {
    props: {
        client: Object,
        index: Number,
        categories: Array,
        deleteClient: Function,
    },
    computed: {
        editHref() {
            const base = '/admin/clients/edit/' + this.client.id;
            const filters = parseQueryParamsFromSearch(window.location.search);

            return appendQueryParamsToPath(base, filters);
        }
    },

    methods: {
        getClientHeader(client) {
            return '#' + client.id + ' ' + client.name + ' '
                + (client.token_number ? '[' + client.token_number + ']' : '')
                + (client.sector ? '[' + client.sector + ']' : '');
        },
        showDeleteDialog(id) {
            if (window.confirm('Czy na pewno chcesz usunąć wpis #' + id + '?')) {
                this.deleteClient(id);
            }
        },
    }
}
</script>
