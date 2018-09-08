<template>
    <div>
        <h2>Modyfikacje do gry {{ game }}</h2>


        <game-mods-category
                v-for="category in categories"
                :key="category.id"
                :category="category"
        ></game-mods-category>
    </div>
</template>
<script>
    import routeMixin from '../route-mixin.js';
    import GameModsCategory from './GameModsCategory.vue';
    export default {
        mixins: [ routeMixin ],
        data() {
            return {
                categories: [],
                game: '',
            };
        },
        methods: {
            assignData({categories, game}) {
                this.categories = categories;
                this.game = game;
            },
        },
        components: {
            GameModsCategory
        }
    }
</script>