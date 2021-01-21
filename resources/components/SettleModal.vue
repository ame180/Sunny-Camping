<template>
    <div>
        <div class="p-2">
            <h1 class="text-center">{{data.firstName + " " + data.lastName}}</h1>
        </div>
        <div class="row no-gutters">
            <div class="col p-1">
                <a @click="$modal.hide('settle-modal')" class="btn btn-outline-secondary w-100 h-100">Anuluj</a>
            </div>
            <div class="col p-1">
                <a @click="submitSettlement(); $modal.hide('settle-modal');"
                   class="btn btn-outline-secondary w-100 h-100">Rozlicz</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        methods: {
            submitSettlement() {

            }
        }
    }
</script>
