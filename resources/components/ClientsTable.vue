<template>
    <div>
        <vuetable ref="vuetable"
                  :api-url="'clients/paginated-json'"
                  :fields="fields"
                  data-path="data"
                  pagination-path=""
                  :css="css.table"
                  @vuetable:pagination-data="onPaginationData"
        >
            <div slot="id-slot" slot-scope="props">
                <b>{{ props.rowData.id }}</b>
            </div>
            <div slot="full-name-slot" slot-scope="props">
                {{ props.rowData.firstName }} {{ props.rowData.lastName }}
            </div>
            <div slot="people-slot" slot-scope="props">
                {{ props.rowData.adults }} + {{ props.rowData.children }}
            </div>
            <div slot="places-slot" slot-scope="props">
                {{ props.rowData.smallPlaces }} + {{ props.rowData.bigPlaces }}
            </div>
            <div slot="options-slot" slot-scope="props" class="row no-gutters">
                <div class="col">
                    <a class="btn btn-primary"
                       :href="'clients/edit/' + props.rowData.id">
                        <i class="far fa-sticky-note"></i>
                    </a>
                </div>
                <form @submit.prevent="showDeleteDialog(props.rowData.id)" method="POST" action=""
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
            :onEachSide="2"
            @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
        <v-dialog></v-dialog>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2'
    import VuetablePagination from './VuetablePagination'

    export default {
        components: {
            Vuetable,
            VuetablePagination
        },
        methods:
            {
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
                    axios.delete(baseUrl + '/admin/clients/delete/' + id);
                    this.$refs.vuetable.tableData.forEach((client, index) => {
                        if (id === client.id) this.$refs.vuetable.tableData.splice(index, 1);
                    });
                    this.$refs.vuetable.reload();
                },
                onPaginationData(paginationData) {
                    this.$refs.pagination.setPaginationData(paginationData)
                },
                onChangePage(page) {
                    this.$refs.vuetable.changePage(page)
                }
            },
        data() {
            return {
                fields: [
                    {
                        name: 'id-slot',
                        title: '#'
                    },
                    {
                        name: 'full-name-slot',
                        title: 'Imię i Nazwisko'
                    },
                    {
                        name: 'arrivalDate',
                        title: 'Data Przyjazdu'
                    },
                    {
                        name: 'departureDate',
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
                ],
                css: {
                    table: {
                        tableClass: 'table table-responsive-lg table-bordered table-striped table-hover text-center mt-3',
                    },
                    pagination: {
                        wrapperClass: 'pagination',
                        activeClass: 'active',
                        disabledClass: 'disabled',
                        pageClass: 'page-item',
                        linkClass: 'page-link',
                        paginationClass: 'pagination',
                        paginationInfoClass: 'float-left',
                        dropdownClass: 'form-control',
                        icons: {
                            first: 'fa fa-angle-double-left',
                            prev: 'fa fa-angle-left',
                            next: 'fa fa-angle-right',
                            last: 'fa fa-angle-double-right',
                        }
                    }
                },
            }
        }
    }
</script>
