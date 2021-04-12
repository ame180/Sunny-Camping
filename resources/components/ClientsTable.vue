<template>
    <div>
        <vuetable ref="vuetable"
                  :api-url="'../api/client/paginated'"
                  :fields="fields"
                  data-path="data"
                  no-data-template="Brak klientów do wyświetlenia"
                  pagination-path=""
                  :css="css.table"
                  @vuetable:pagination-data="onPaginationData"
        >
            <div slot="id-slot" slot-scope="props">
                <b>{{ props.rowData.id }}</b>
            </div>
            <div slot="name-slot" slot-scope="props">
                {{ props.rowData.name }}
            </div>
            <div slot="options-slot" slot-scope="props" class="row no-gutters">
                <div class="col-12 p-1">
                    <a class="btn btn-primary"
                       :href="'clients/edit/' + props.rowData.id">
                        <i class="far fa-fw fa-sticky-note"></i>
                    </a>
                </div>
                <form @submit.prevent="showDeleteDialog(props.rowData.id)" method="POST" action=""
                      class="col-12 p-1 m-0">
                    <button class="btn btn-danger">
                        <i class="far fa-fw fa-trash-alt"></i>
                    </button>
                </form>
                <div class="col-12 p-1">
                    <a @click="showSettleModal(props.rowData)"
                       class="btn btn-warning text-light">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                    </a>
                </div>
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
import SettleModal from "./SettleModal";

export default {
    components: {
        Vuetable,
        VuetablePagination
    },
    methods:
        {
            showSettleModal(data) {
                this.$modal.show(SettleModal,
                    {
                        data: data,
                        refreshTable: this.$refs.vuetable.refresh
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
                        this.$refs.vuetable.reload()
                    });
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
                    name: 'name-slot',
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
                    name: 'discount',
                    title: 'Rabat',
                    formatter: (value) => value + '%'
                },
                {
                    name: 'price',
                    title: 'Cena',
                    formatter: (value) => value + ' zł'
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
                    tableClass: 'table table-responsive table-bordered table-striped table-hover text-center mt-3',
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
