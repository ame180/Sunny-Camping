<template>
    <vuetable ref="vuetable"
              :api-url="'clients/getAllJson'"
              :fields="[
              {
                name: 'id-slot',
                title: '#'
              },
              {
                name: 'full-name-slot',
                title: 'Imię i Nazwisko'
              },
              {
                name: 'arrival_date',
                title: 'Data Przyjazdu'
              },
              {
                name: 'departure_date',
                title: 'Data Odjazdu'
              },
              {
                name: 'sector',
                title: 'Sektor'
              },
              {
                name: 'people-slot',
                title: 'Osoby'
              },
              {
                name: 'electricity',
                title: 'Prąd'
              },
              {
                name: 'places-slot',
                title: 'Miejsca'
              },
              {
                name: 'discount',
                title: 'Rabat'
              },
              {
                name: 'price',
                title: 'Cena'
              },
              {
                name: 'comment',
                title: 'Komentarz'
              },
              {
                name: 'options-slot',
                title: 'Opcje',
              }
              ]"
              data-path=""
              pagination-path=""
              :css="css.table"
    >
        <div slot="id-slot" slot-scope="props">
            <b>{{ props.rowData.id }}</b>
        </div>
        <div slot="full-name-slot" slot-scope="props">
            {{ props.rowData.first_name }} {{ props.rowData.last_name }}
        </div>
        <div slot="people-slot" slot-scope="props">
            {{ props.rowData.adults }} + {{ props.rowData.children }}
        </div>
        <div slot="places-slot" slot-scope="props">
            {{ props.rowData.small_places }} + {{ props.rowData.big_places }}
        </div>
        <div slot="options-slot" slot-scope="props" class="row no-gutters">
            <div class="col">
                <a class="btn btn-primary"
                   :href="'clients/edit/' + props.rowData.id">
                    <i class="far fa-sticky-note"></i>
                </a>
            </div>
            <form v-on:submit.prevent="deleteClient(props.rowData.id, $event)" method="POST" action=""
                  class="col m-0">
                <button class="btn btn-danger">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </vuetable>
</template>

<script>
    import Vuetable from 'vuetable-2'
    import VuetableRowHeader from 'vuetable-2/src/components/VuetableRowHeader.vue'

    export default {
        components: {
            Vuetable,
            VuetableRowHeader
        },
        data() {
            return {
                css: {
                    table: {
                        tableClass: 'table table-responsive-lg table-bordered table-striped table-hover text-center mt-3',
                    },
                }
            }
        },
        methods: {
            deleteClient: function (id, event) {
                event.preventDefault();
                axios.delete(baseUrl + '/admin/clients/delete/' + id, {
                    //_method: 'DELETE'
                });
                this.$refs.vuetable.tableData.forEach((client, index) => {
                    if (id === client.id) this.$refs.vuetable.tableData.splice(index, 1);
                });
            },
        },
    }
</script>
