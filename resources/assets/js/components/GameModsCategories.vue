<template>
    <div>
        <router-link :to="{ name: 'category_create', params: { game: game.id } }">
            Stwórz nową kategorię
        </router-link>

        <h2>Modyfikacje do gry {{ game.title }}</h2>

        <game-mods-category
                v-for="category in categories"
                :key="category.id"
                :category="category"
                :gameid="game.id"
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