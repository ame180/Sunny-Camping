<template>
    <div>
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
                  data-path="data"
                  pagination-path=""
                  :css="css.table"
                  @vuetable:pagination-data="onPaginationData"
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
        <vuetable-pagination
            ref="pagination"
            :css="css.pagination"
            @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'

    export default {
        components: {
            Vuetable,
            VuetablePagination
        },
        data() {
            return {
                css: {
                    table: {
                        tableClass: 'table table-responsive-lg table-bordered table-striped table-hover text-center mt-3',
                    },
                    pagination: {
                        wrapperClass: 'text-center',
                        activeClass: 'active large',
                        disabledClass: 'disabled',
                        pageClass: 'item',
                        linkClass: 'icon item',
                        paginationClass: 'ui bottom attached segment grid',
                        paginationInfoClass: 'left floated left aligned six wide column',
                        dropdownClass: 'ui search dropdown',
                        icons: {
                            first: 'fas fa-angle-double-left',
                            prev: 'fas fa-angle-left',
                            next: 'fas fa-angle-right',
                            last: 'fas fa-angle-double-right',
                        }
                    },
                }
            }
        },
        methods: {
            deleteClient: function (id, event) {
                event.preventDefault();
                //axios.delete(baseUrl + '/admin/clients/delete/' + id);
                this.$refs.vuetable.tableData.forEach((client, index) => {
                    if (id === client.id) this.$refs.vuetable.tableData.splice(index, 1);
                });
                console.log(this.$refs.vuetable.tableData.totalPage);
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            // when the user click something that causes the page to change,
            // call "changePage" method in Vuetable, so that that page will be
            // requested from the API endpoint.
            onChangePage(page) {
                this.$refs.vuetable.changePage(page)
            }
        },
    }
</script>
