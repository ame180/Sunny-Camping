<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarToggleCustomAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
        <div class="collapse" id="navbarToggleCustomAdmin">
            <div class="bg-dark p-4">
                <ul class="nav navbar-nav">
                    <li v-for="(item, i) in items" :class="classes(item)">
                        <a
                            v-if="item.children.length === 0"
                            :target="item.target"
                            :href="item.href"
                            :style="'color:'+color(item)"
                            class="d-block w-100 p-3"
                        >
                            <span :class="'icon '+item.icon_class"></span>
                            <span class="title">{{ item.title }}</span>
                        </a>
                        <a v-else
                           class="nested-collapse d-block w-100 p-3"
                           data-toggle="collapse"
                           :href="'#nestedDropDown'+item.id"
                           :aria-controls="'nestedDropDown'+item.id"
                           :style="'color:'+color(item)"
                           role="button"
                           aria-expanded="false">
                            <span :class="'icon '+item.icon_class"></span>
                            <span class="title">{{ item.title }}</span>
                        </a>
                        <div
                            v-if="item.children.length > 0"
                            class="collapse"
                            :id="'nestedDropDown'+item.id">
                            <ul class="nav navbar-nav ml-4 p-3">
                                <li v-for="(item, i) in item.children" :class="classes(item)">
                                    <a
                                        :href="item.href"
                                        :target="item.target"
                                    >
                                        <span :class="'icon '+item.icon_class"></span>
                                        <span class="title">{{ item.title }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        items: {
            type: Array,
            default: [],
        }
    },
    methods: {
        classes: function (item) {
            var classes = [];
            if (item.children.length > 0) {
                classes.push('dropdown');
            }
            if (item.active) {
                classes.push('active');
            }


            return classes.join(' ');
        },
        color: function (item) {
            if (item.color && item.color != '#000000') {
                return item.color;
            }

            return '';
        }
    }
};
</script>
<style lang="scss">
.nav.navbar-nav {
    font-size: 1.5rem;

    .icon {
        font-size: 2rem;
    }
}

.nested-collapse:after {
    font-family: Voyager;
    content: "\E038";
    position: absolute;
    right: 1em;
}
</style>
