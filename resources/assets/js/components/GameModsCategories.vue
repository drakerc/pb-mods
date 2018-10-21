<template>
    <div :style="backgroundImageStyle">
        <div class="container">
            <div class="jumbotron text-white p-3 p-md-5 rounded bg-dark">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="display-4 font-italic">Modyfikacje do gry {{ game.title }}</h1>
                        <p v-if="game.description" v-html="$options.filters.truncate(game.description, 200)"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <game-mods-category
                            v-for="category in categories"
                            :key="category.id"
                            :category="category"
                            :gameid="game.id"
                    ></game-mods-category>
                </div>
                <div class="col-md-2 rounded bg-light">
                    <h2>Menu</h2>
                    <ol class="list-unstyled">
                        <router-link :to="{ name: 'category_create', params: { game: game.id}}">
                            <li>Stwórz nową kategorię</li>
                        </router-link>
                    </ol>
                </div>
            </div>
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