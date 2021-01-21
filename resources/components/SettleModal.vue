<template>
    <div>
        <div class="p-2">
            <h1 class="text-center">Rozliczenie</h1>
            <b>
                #{{data.id}}<br>
                {{data.firstName}} {{data.lastName}}<br>
                Dni: {{(new Date(data.departureDate) - new Date(data.arrivalDate)) / (1000 * 60 * 60 * 24)}}<br>
                Suma: {{data.price}} zł
            </b>
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
