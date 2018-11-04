<template>
    <div :style="backgroundImageStyle">
        <loading :active.sync="isLoading" is-full-page=true></loading>

        <div class="container">
            <div class="jumbotron text-white p-3 p-md-5 rounded bg-dark">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="display-4 font-italic">{{ category.title }}</h1>
                        <p v-html="category.description"></p>
                        <display-timestamps :created_at="category.created_at" :updated_at="category.updated_at">
                        </display-timestamps>
                    </div>
                    <div id="category-thumbnail" class="col-md-4" v-if="category.thumbnail !== null">
                        <img :src="category.thumbnail"/>
                    </div>
                </div>
            </div>
            <div class="container jumbotron rounded main-container">
                <ul class="nav nav-pills nav-fill border">
                    <li class="nav-item">
                        <router-link
                                :to="{ name: 'category_create', params: { game: $route.params['game'], category: category.id } }">
                            <a class="nav-link" id="create-new-category">
                                <font-awesome-icon icon="list-ol" />
                                Stwórz nową kategorię</a>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'modification_create', params: { game: $route.params['game'], category: category.id } }">
                            <a class="nav-link" id="create-new-mod">
                                <font-awesome-icon icon="cogs" />
                                Stwórz nową modyfikację
                            </a>
                        </router-link>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Modyfikacje</h2>
                        <category-mods v-on:start-loading="loadingStarted" v-on:complete-loading="loadingComplete" :category="category.id"></category-mods>
                    </div>
                    <div v-if="category.subcategories !== [] && category.subcategories !== undefined" class="col-md-12">
                        <h2>Podkategorie</h2>
                        <display-subcategories :subcategory=false :categoryId="category.id" :categories="category.subcategories" :gameid="$route.params['game']"></display-subcategories>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import DisplayTimestamps from '../../DisplayTimestamps';
    import DisplaySubcategories from './DisplaySubcategories';
    import CategoryMods from './CategoryMods';
    import routeMixin from '../../../route-mixin.js';
    import pagination from 'laravel-vue-pagination';

    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        mixins: [ routeMixin ],
        data() {
            return {
                category: [],
                isLoading: true,
            }
        },
        components: {
            DisplayTimestamps,
            DisplaySubcategories,
            CategoryMods,
            pagination,
            Loading
        },
        mounted() {
            if (this.category.length === 0) {
                // This is a really stupid hack that will fetch data when a route's param (ID) changes, as Vue does not reload anything then
                axios.get('/api/mods/' + this.$route.params['game'] + '/category/' + this.$route.params['category']).then(({data}) => {
                    this.category = data['category'];
                });
            }
        },
        computed: {
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.category.background}")`,
                    'background-repeat': 'no-repeat',
                    'background-size': '100%',
                }
            },
        },
        methods: {
            assignData({category}) {
                this.category = category;
                this.$emit('set-mod-link', this.$route.params['game'], this.category.id);
            },
            getResults(page = 1) {
                axios.get('/api/mods/' + this.game.id + '?page=' + page)
                    .then(response => {
                        this.categories = response.data.categories;
                    });
            },
            loadingStarted() {
                this.isLoading = true;
            },
            loadingComplete() {
                this.isLoading = false;
            }
        }
    }
</script>
<style>
    #category-thumbnail img {
        max-width: 200px;
    }
    .main-container {
        opacity: 0.95;
    }
</style>