<template>
    <div>
        <div class="container">
            <img v-if="image !== null" :src="image"/>
            <div class="heading">
                <h1>{{ title }}</h1>
                <p>{{ description }}</p>
            </div>
            <hr>
            <div class="about">
                <!-- TODO: add a way to check if a category is a main mods category-->
                <h3 v-if="game_category === false && parent != null ">Mods for {{ parent }}</h3>
            </div>
            <div class="lists">
                <display-timestamps :created_at="created_at" :updated_at="updated_at">
                </display-timestamps>
            </div>

            <div class="category-tree">
                <display-subcategories :categories="subcategories"></display-subcategories>
            </div>
        </div>
    </div>
</template>
<script>
    import DisplayTimestamps from './DisplayTimestamps';
    import DisplaySubcategories from './DisplaySubcategories';

    let model = JSON.parse(window.mods_model);
    export default {
        data() {
            return Object.assign(model, {});
        },
        components: {
            DisplayTimestamps,
            DisplaySubcategories,
        },
        methods: {
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