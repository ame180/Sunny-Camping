<template>
    <div class="text-center">
        <a class="btn btn-lg btn-primary m-1" :href="addClientHref">Dodaj klienta</a>
        <a class="btn btn-lg btn-primary m-1" href="/api/clients/export-registered">Exportuj</a>
    </div>
</template>

<script>
import { appendFiltersToPath, parseFiltersFromSearch } from "../js/utils/clientsFilters";

export default {
    props: {
        basePath: {
            type: String,
            default: '/admin/clients/add-client'
        }
    },
    computed: {
        addClientHref() {
            const filters = parseFiltersFromSearch(window.location.search);

            return appendFiltersToPath(this.basePath, filters);
        }
    }
}
</script>
