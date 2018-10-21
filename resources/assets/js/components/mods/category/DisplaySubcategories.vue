<template>
    <div>
        <div class="row" v-if="!subcategory">
            <div v-for="(value, index) in subcategories" class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <div class="card-body">
                        <router-link :to="{ name: 'mods_category', params: { game: gameid, category: value.id } }">
                            <h5 class="card-title">{{ value.title }} ({{ value.deepSubcategoriesCount }}
                                podkategorie)</h5>
                        </router-link>
                        <p v-if="value.description" class="card-text" v-html="$options.filters.truncate(value.description, 200)"></p>

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{
                                value.deepSubcategoriesCount }} podkategorii
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{
                                value.deepModificationsCount}} modyfikacji
                            </button>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-lg btn-outline-primary"
                                   v-if="value.subcategories === undefined && value.subcategoriesCount > 0"
                                   @click="getSubcategories(index, value.id)">
                                    Rozwiń podkategorie [+]
                                </a>
                            </div>
                        </div>

                        <div v-if="value.children" v-for="child in value.children">
                            <display-subcategories :categories="[child]" :gameid="gameid"
                                                   :subcategory=true></display-subcategories>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="subcategory">
            <ul class="list-group">
                <li v-for="(value, index) in subcategories" class="list-group-item">
                    <router-link :to="{ name: 'mods_category', params: { game: gameid, category: value.id } }">
                        <p>{{ value.title }} ({{ value.deepSubcategoriesCount }} podkategorie)</p>
                    </router-link>
                    <a href="#" v-if="value.subcategories === undefined && value.subcategoriesCount > 0"
                       @click="getSubcategories(index, value.id)">
                        [+]
                    </a>
                    <div v-if="value.children" v-for="child in value.children">
                        <display-subcategories :categories="[child]" :gameid="gameid"
                                               :subcategory=true></display-subcategories>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import DisplaySubcategories from './DisplaySubcategories';
    import axios from "axios";

    export default {
        props: ['categories', 'gameid', 'subcategory'],
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
