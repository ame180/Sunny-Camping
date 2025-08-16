<template>
    <div class="text-center">
        <a class="btn btn-lg btn-primary m-1" :href="addClientHref">Dodaj klienta</a>
        <a class="btn btn-lg btn-primary m-1" href="/api/clients/export-registered">Exportuj</a>
    </div>
</template>

<script>
import { appendQueryParamsToPath, parseQueryParamsFromSearch } from "../js/utils/clientsQuery";

export default {
    props: {
        basePath: {
            type: String,
            default: '/admin/clients/add-client'
        }
    },
    computed: {
        addClientHref() {
            const filters = parseQueryParamsFromSearch(window.location.search);

            return appendQueryParamsToPath(this.basePath, filters);
        }
    }
}
</script>
