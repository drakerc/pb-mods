<template>
    <div>
        <div class="container">
            <router-link :to="{ name: 'game_mods', params: { game: $route.params['game'], category: category.id } }">
                <a href="#">Wróć do głównej strony modów do tej gry</a>
            </router-link>

            <img v-if="category.image !== null" :src="category.image"/>
            <div class="heading">
                <h1>{{ category.title }}</h1>
                <p>{{ category.description }}</p>
            </div>
            <hr>
            <div class="lists">
                <display-timestamps :created_at="category.created_at" :updated_at="category.updated_at">
                </display-timestamps>
            </div>

            <div class="category-tree">
                <display-subcategories v-if="category.subcategories !== [] && category.subcategories !== undefined" :categories="category.subcategories" :gameid="$route.params['game']"></display-subcategories>
            </div>

            <div class="mods">
                <category-mods :category="category.id"></category-mods>
            </div>
        </div>
    </div>
</template>
<script>
    import DisplayTimestamps from './DisplayTimestamps';
    import DisplaySubcategories from './DisplaySubcategories';
    import CategoryMods from './CategoryMods';
    import routeMixin from '../route-mixin.js';

    export default {
        mixins: [ routeMixin ],
        data() {
            return {
                category: [],
                testString: '',
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
        methods: {
            assignData({category}) {
                this.category = category;
            },
        }
    }
</script>
<style>
    .about {
        margin: 2em 0;
    }
    .about h3 {
        font-size: 22px;
    }
</style>