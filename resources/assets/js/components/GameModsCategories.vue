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
            <ul class="nav nav-pills nav-fill border">
                <li class="nav-item">
                    <router-link :to="{ name: 'category_create', params: { game: game.id}}">
                        <a class="nav-link">
                            <font-awesome-icon icon="list-ol" />
                            Stwórz nową kategorię
                        </a>
                    </router-link>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <game-mods-category
                                v-for="category in categories.data"
                                :key="category.id"
                                :category="category"
                                :gameid="game.id"
                        ></game-mods-category>
                    </div>
                </div>
            </div>
            <div class="footer" v-if="categories.from !== undefined">
                <pagination :data="categories" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
    </div>

</template>
<script>
    import routeMixin from '../route-mixin.js';
    import GameModsCategory from './mods/category/GameModsCategory.vue';
    import pagination from 'laravel-vue-pagination';
    import axios from 'axios';

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
            getResults(page = 1) {
                axios.get('/api/mods/' + this.game.id + '?page=' + page)
                    .then(response => {
                        this.categories = response.data.categories;
                    });
            }
        },
        computed: {
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.game.background}")`
                }
            }
        },
        components: {
            GameModsCategory,
            pagination
        }
    }
</script>