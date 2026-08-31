<template>
    <div class="client-name-input">
        <input
            id="name"
            :value="value"
            :class="{ 'is-invalid': invalid }"
            @input="onInput"
            @keydown.down="highlightNext"
            @keydown.up="highlightPrevious"
            @keydown.enter="onEnter"
            @keydown.esc="closeSuggestions"
            @blur="onBlur"
            name="name"
            type="text" placeholder="Imię i nazwisko"
            class="form-control form-control-sm"
            autocomplete="off"
        >
        <div v-if="isOpen" class="dropdown-menu d-block w-100 client-name-input__suggestions">
            <button
                v-for="(suggestion, index) in suggestions"
                :key="index"
                ref="options"
                :class="{ active: index === highlightedIndex }"
                @mousedown.prevent="selectSuggestion(suggestion)"
                @mouseenter="highlightedIndex = index"
                type="button"
                class="dropdown-item"
            >
                {{ suggestion.name }}
                <small v-if="describeLocation(suggestion)" class="text-muted">{{ describeLocation(suggestion) }}</small>
            </button>
        </div>
    </div>
</template>

<script>
const MINIMUM_QUERY_LENGTH = 2;

export default {
    props: ['value', 'invalid'],
    data() {
        return {
            suggestions: [],
            isOpen: false,
            highlightedIndex: -1
        }
    },
    created() {
        this.latestRequestId = 0;
        this.fetchSuggestions = _.debounce(this.fetchSuggestionsNow, 200);
    },
    methods: {
        onInput(event) {
            this.$emit('input', event.target.value);
            this.fetchSuggestions();
        },
        onBlur() {
            this.closeSuggestions();

            if (typeof this.value === 'string' && this.value !== this.value.trim()) {
                this.$emit('input', this.value.trim());
            }
        },
        fetchSuggestionsNow() {
            const searchQuery = this.value ? this.value.trim() : '';

            if (searchQuery.length < MINIMUM_QUERY_LENGTH) {
                this.closeSuggestions();
                return;
            }

            const requestId = ++this.latestRequestId;

            axios.get(baseUrl + '/api/clients/suggestions', { params: { query: searchQuery } })
                .then((response) => {
                    if (requestId !== this.latestRequestId) {
                        return;
                    }
                    this.suggestions = response.data;
                    this.isOpen = this.suggestions.length > 0;
                    this.highlightedIndex = -1;
                })
                .catch(() => {
                    if (requestId !== this.latestRequestId) {
                        return;
                    }
                    this.closeSuggestions();
                });
        },
        selectSuggestion(suggestion) {
            this.$emit('select', suggestion);
            this.closeSuggestions();
        },
        closeSuggestions() {
            this.fetchSuggestions.cancel();
            this.latestRequestId++;
            this.suggestions = [];
            this.isOpen = false;
            this.highlightedIndex = -1;
        },
        highlightNext(event) {
            if (!this.isOpen) {
                return;
            }
            event.preventDefault();
            this.moveHighlight(1);
        },
        highlightPrevious(event) {
            if (!this.isOpen) {
                return;
            }
            event.preventDefault();
            this.moveHighlight(-1);
        },
        moveHighlight(offset) {
            const count = this.suggestions.length;
            const current = this.highlightedIndex < 0 ? (offset > 0 ? -1 : 0) : this.highlightedIndex;

            this.highlightedIndex = (current + offset + count) % count;
            this.$nextTick(() => this.scrollHighlightedIntoView());
        },
        scrollHighlightedIntoView() {
            const options = this.$refs.options;

            if (!options || !options[this.highlightedIndex]) {
                return;
            }

            options[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
        },
        onEnter(event) {
            if (!this.isOpen || this.highlightedIndex < 0) {
                return;
            }
            event.preventDefault();
            this.selectSuggestion(this.suggestions[this.highlightedIndex]);
        },
        describeLocation(suggestion) {
            return [suggestion.postcode, suggestion.country].filter(Boolean).join(' · ');
        }
    }
}
</script>

<style scoped>
.client-name-input {
    position: relative;
}

.client-name-input__suggestions {
    min-width: 0;
    max-height: 20rem;
    padding: 0;
    overflow-x: hidden;
    overflow-y: auto;
}

.client-name-input__suggestions .dropdown-item {
    padding: .25rem .5rem;
    line-height: 1.25;
    white-space: normal;
    overflow-wrap: break-word;
}

.client-name-input__suggestions .dropdown-item small {
    display: block;
}

.client-name-input__suggestions .dropdown-item.active small {
    color: inherit !important;
}
</style>
