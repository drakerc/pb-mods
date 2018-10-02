<template>
    <div>
        <ul v-for="(value, index) in subcategories">
            <li>
                <router-link :to="{ name: 'mods_category', params: { game: gameid, category: value.id } }">
                    {{ value.title }} ({{ value.subcategoriesCount }} podkategorie)
                </router-link>
                <a href="#" v-if="value.subcategories === undefined && value.subcategoriesCount > 0" @click="getSubcategories(index, value.id)">
                    [+]
                </a>
            </li>

            <ul v-if="value.children">
                <div v-for="child in value.children">
                    <display-subcategories :categories="[child]" :gameid="gameid"></display-subcategories>
                </div>
            </ul>
        </ul>
    </div>
</template>

<script>
    import DisplaySubcategories from './DisplaySubcategories';
    import axios from "axios";

    export default {
        props: ['categories', 'gameid'],
        components: {
            DisplaySubcategories,
        },
        data: function () {
            return {
                subcategories: this.categories,
            }
        },
        beforeCreate() {
            this.$options.components.DisplaySubcategories = require('./DisplaySubcategories.vue');
        },
        beforeMount: function () {
            var that = this;
            console.log(this.subcategories)
            this.subcategories.forEach(function (item, index) { // TODO: change to => function
                return that.subcategories[index].children = [];
            });
        },
        methods: {
            getSubcategories: function (id, categoryId) {
                axios.get('/api/mods/category/' + categoryId + '/subcategories').then(response => {
                    this.subcategories[id].children = response.data;
                    this.subcategories[id].updated_at = 'now';
                    var newVal = Object.assign({}, this.subcategories[id], {subcategories: true});
                    Vue.set(this.subcategories, id, newVal) // VueJS does not reload the DOM tree after changing an array; using a set method will trigger a reload
                });
            }
    }}
</script>
