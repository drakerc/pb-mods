<template>
    <div>
        <div class="row" v-if="subcategories.length === 0 && !subcategory">
            <p>
                Brak podkategorii. Możesz jednak stworzyć nową podkategorię, korzystając z menu powyżej.
            </p>
        </div>

        <div class="row" v-if="!subcategory">
            <div v-for="(value, index) in subcategories" class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <div class="text-center">
                        <router-link v-if="value.thumbnail !== null" :to="{ name: 'mods_category', params: { game: gameid, category: value.id } }">
                            <img class="card-img-top" :src="'/storage/' + value.thumbnail">
                        </router-link>
                    </div>

                    <div class="card-body">
                        <router-link :to="{ name: 'mods_category', params: { game: gameid, category: value.id } }">
                            <h5 class="card-title">{{ value.title }}</h5>
                        </router-link>
                        <p v-if="value.description" class="card-text" v-html="$options.filters.truncate(value.description, 200)"></p>

                        <div class="subcategories">
                            <div class="d-flex justify-content-between align-items-center">
                                <b-btn variant="outline-primary" block="true" v-if="value.subcategories === undefined && value.subcategoriesCount > 0"
                                       @click.prevent="getSubcategories(index, value.id)">
                                    <font-awesome-icon icon="plus" />
                                    Rozwiń podkategorie
                                </b-btn>
                            </div>

                            <div v-if="value.children" v-for="child in value.children">
                                <display-subcategories :categories="[child]" :gameid="gameid"
                                                       :subcategory=true></display-subcategories>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <font-awesome-icon icon="list-ol" />
                                {{ value.deepSubcategoriesCount }} podkategorii
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <font-awesome-icon icon="list-alt" />
                                {{ value.deepModificationsCount}} modyfikacji
                            </button>
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
                    <a href="#" title="Rozwiń" v-if="value.subcategories === undefined && value.subcategoriesCount > 0"
                       @click.prevent="getSubcategories(index, value.id)">
                        <font-awesome-icon icon="plus" />
                    </a>
                    <div v-if="value.children" v-for="child in value.children">
                        <display-subcategories :categories="[child]" :gameid="gameid"
                                               :subcategory=true></display-subcategories>
                    </div>
                </li>
            </ul>
        </div>
        <div class="footer" v-if="subcategoriesData !== undefined && subcategoriesData.data !== undefined">
            <pagination :data="subcategoriesData" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>

<script>
    import DisplaySubcategories from './DisplaySubcategories';
    import axios from "axios";
    import pagination from 'laravel-vue-pagination';

    export default {
        props: ['categories', 'gameid', 'subcategory', 'categoryId', 'subcatData'],
        components: {
            DisplaySubcategories,
            pagination,
        },
        data: function () {
            return {
                subcategories: this.categories,
                subcategoriesData: this.subcatData,
            }
        },
        beforeCreate() {
            this.$options.components.DisplaySubcategories = require('./DisplaySubcategories.vue');
        },
        beforeMount: function () {
            if (this.subcategory) {
                var that = this;
                this.subcategories.forEach(function (item, index) {
                    return that.subcategories[index].children = [];
                });
            } else {
                this.subcategoriesData = this.categories;
                this.subcategories = this.categories.data;
                var that = this;
                this.subcategories.forEach(function (item, index) {
                    return that.subcategories[index].children = [];
                });
            }
        },
        methods: {
            getSubcategories: function (id, categoryId) {
                axios.get('/api/mods/category/' + categoryId + '/subcategories').then(response => {
                    // this.subcategoriesData = response.data;
                    this.subcategories[id].children = response.data.data;
                    this.subcategories[id].updated_at = 'now';
                    var newVal = Object.assign({}, this.subcategories[id], {subcategories: true});
                    Vue.set(this.subcategories, id, newVal) // VueJS does not reload the DOM tree after changing an array; using a set method will trigger a reload
                });
            },
            getResults(page = 1) {
                axios.get('/api/mods/category/' + this.categoryId + '/subcategories/?page=' + page)
                    .then(response => {
                        this.subcategoriesData = response.data;
                        this.subcategories = response.data.data;
                    });
            },
    }}
</script>
<style>
    .subcategories {
        margin: 5px;
        padding: 2px;
    }
</style>
