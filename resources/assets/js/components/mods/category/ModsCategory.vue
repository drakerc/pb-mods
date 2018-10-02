<template>
    <div :style="backgroundImageStyle">
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

            <div class="row">
                <div v-if="category.subcategories !== [] && category.subcategories !== undefined" class="col-md-10">
                    <h2>Podkategorie</h2>
                    <display-subcategories :categories="category.subcategories" :gameid="$route.params['game']"></display-subcategories>
                </div>
                <div class="col-md-2 rounded bg-dark">
                    <h2>Menu</h2>
                    <ol class="list-unstyled">
                        <router-link :to="{ name: 'category_create', params: { game: $route.params['game'], category: category.id } }">
                            <li>Stwórz nową kategorię</li>
                        </router-link>
                        <router-link :to="{ name: 'modification_create', params: { game: $route.params['game'], category: category.id } }">
                            <li>Stwórz nową modyfikację</li>
                        </router-link>
                    </ol>
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

    export default {
        mixins: [ routeMixin ],
        data() {
            return {
                category: [],
            }
        },
        components: {
            DisplayTimestamps,
            DisplaySubcategories,
            CategoryMods,
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
                    'background-image': `url("${this.category.background}")`
                }
            }
        },
        methods: {
            assignData({category}) {
                this.category = category;
                this.$emit('set-mod-link', this.$route.params['game'], this.category.id);
            },
        }
    }
</script>
<style>
    #category-thumbnail img {
        max-width: 200px;
    }
</style>