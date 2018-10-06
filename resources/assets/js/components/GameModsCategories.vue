<template>
    <div :style="backgroundImageStyle">
        <router-link :to="{ name: 'category_create', params: { game: game.id } }">
            Stwórz nową kategorię
        </router-link>

        <h2>Modyfikacje do gry {{ game.title }}</h2>

        <div class="row">
            <game-mods-category
                    v-for="category in categories"
                    :key="category.id"
                    :category="category"
                    :gameid="game.id"
            ></game-mods-category>

        </div>


    </div>
</template>
<script>
    import routeMixin from '../route-mixin.js';
    import GameModsCategory from './mods/category/GameModsCategory.vue';
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
                this.$emit('set-mod-link', this.game.id);
            },
        },
        computed: {
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.game.background}")`
                }
            }
        },
        components: {
            GameModsCategory
        }
    }
</script>