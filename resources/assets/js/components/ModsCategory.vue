<template>
    <div>
        <div class="container">
            <img v-if="category.image !== null" :src="category.image"/>
            <div class="heading">
                <h1>{{ category.title }}</h1>
                <p>{{ category.description }}</p>
            </div>
            <hr>
            <div class="about">
                <!-- TODO: add a way to check if a category is a main mods category-->
                <h3 v-if="category.game_category === false && parent != null ">Mods for {{ category.parent }}</h3>
            </div>
            <div class="lists">
                <display-timestamps :created_at="category.created_at" :updated_at="category.updated_at">
                </display-timestamps>
            </div>

            <div class="category-tree">
                <display-subcategories v-if="category.subcategories !== [] && category.subcategories !== undefined" :categories="category.subcategories"></display-subcategories>
            </div>
        </div>
    </div>
</template>
<script>
    import DisplayTimestamps from './DisplayTimestamps';
    import DisplaySubcategories from './DisplaySubcategories';
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
        },
        mounted() {
            if (this.category.length === 0) {
                // This is a really stupid hack that will fetch data when a route's param (ID) changes, as Vue does not reload anything then
                axios.get(`/api/mods/category/` + this.$route.params['category']).then(({data}) => {
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