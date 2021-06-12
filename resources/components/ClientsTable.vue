<template>
    <div>
        <div class="row border" v-for="client in clients.data">
            <div class="col border-right p-2">
                <div>
                    <b>#{{ client.id }} {{ client.name }}</b>
                </div>
                <div v-for="item in client.client_items" v-if="item.service_category && item.service_category.name == 'Prąd'">
                    {{ item.name }}
                </div>
            </div>
            <div class="col-3 col-sm-2">
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
    </div>
</template>

<script>
import SettleModal from "./SettleModal";

export default {
    props: ['clients'],
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
        },
    data() {
        return {}
    }
}
</script>
