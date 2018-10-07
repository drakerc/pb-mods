<template>
    <div :style="backgroundImageStyle">
            <div class="jumbotron text-white rounded" :style="splashImageStyle">
                <div class="row">
                    <div class="col-md-8 bg-semi-transparent">
                        <div class="row">
                        <div class="col-md-9">
                            <h1 class="display-4 font-italic" :style="fontTitle">{{ mod.title }}</h1>
                            <div>Status produkcji: {{ mod.development_status }}</div>
                            <div>Wielkość: {{ mod.size }}</div>
                            <div>Zamienia: {{ mod.replaces }}</div>
                            <div>Wersja: {{ mod.version }}</div>
                            <div>Data wydania: {{ mod.release_date }}</div>
                            <div>Studio developerskie: {{ mod.development_studio }}</div>
                        </div>
                        <div class="col-md-3">
                            <display-total-rating :rating="mod.averageRating"></display-total-rating>
                        </div>
                        </div>
                        <p v-if="mod.description" v-html="$options.filters.truncate(mod.description, 100)"></p>
                    </div>
                </div>
            </div>

        <div class="container">
            <b-nav tabs>
                <b-nav-item :active="active === 'description'" @click="active = 'description'">Opis</b-nav-item>
                <b-nav-item :active="active === 'pictures'" @click="active = 'pictures'">Obrazki</b-nav-item>
                <b-nav-item :active="active === 'videos'" @click="active = 'videos'">Filmiki</b-nav-item>
                <b-nav-item :active="active === 'suggestions'" @click="active = 'suggestions'">Sugestie</b-nav-item>
                <b-nav-item :active="active === 'reviews'" @click="active = 'reviews'">Opinie</b-nav-item>
                <b-nav-item :active="active === 'files'" @click="active = 'files'" >Pliki</b-nav-item>
                <b-nav-item :active="active === 'authorsMenu'" @click="active = 'authorsMenu'">Dla autora</b-nav-item>
            </b-nav>

            <div v-if="active === 'description'">
                <div v-html="mod.description"></div>
            </div>

            <div v-if="active === 'pictures'">
                <modification-gallery v-if="mod.id !== undefined" :modification="mod"></modification-gallery>
            </div>

            <div v-if="active === 'videos'">
                <modification-videos v-if="mod.id !== undefined" :modification="mod"></modification-videos>
            </div>

            <div v-if="active === 'reviews'">
                <router-link :to="{ name: 'modification_create_rating', params: { mod: mod.id } }">
                    Dodaj swoją opinię
                </router-link>
                <display-ratings :passedMod="mod"></display-ratings>
            </div>

            <div v-if="active === 'files'">
                <modification-files v-if="mod.id !== undefined" :modification="mod"></modification-files>
            </div>

            <div v-if="active === 'authorsMenu'">
                <modification-author-menu :mod="mod"></modification-author-menu>
            </div>

        </div>





        <!--<modification-author-menu :mod="mod"></modification-author-menu>-->

        <!--<router-link :to="{ name: 'modification_create_rating', params: { mod: mod.id } }">-->
            <!--Dodaj swoją opinię-->
        <!--</router-link>-->

        <!--<router-link :to="{ name: 'modification_ratings', params: { mod: mod.id } }">-->
            <!--Opinie-->
        <!--</router-link>-->

        <!--<div>{{ mod.title }}</div>-->
        <!--<div v-html="mod.description"></div>-->
        <!--<div>{{ mod.development_status }}</div>-->
        <!--<div>{{ mod.size }}</div>-->
        <!--<div>{{ mod.replaces }}</div>-->
        <!--<div>{{ mod.version }}</div>-->
        <!--<div>{{ mod.release_date }}</div>-->
        <!--<div>{{ mod.development_studio }}</div>-->

        <!--<display-total-rating :rating="mod.averageRating"></display-total-rating>-->

        <!--<div>-->
            <!--<h1>Pliki:</h1>-->
            <!--<modification-files v-if="mod.id !== undefined" :modification="mod"></modification-files>-->
        <!--</div>-->

        <!--Galeria screenów:-->
        <!--<modification-gallery v-if="mod.id !== undefined" :modification="mod"></modification-gallery>-->

        <!--Filmiki:-->
        <!--<modification-videos v-if="mod.id !== undefined" :modification="mod"></modification-videos>-->
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import ModificationFiles from "../file/ModificationFiles";
    import ModificationGallery from "./ModificationGallery";
    import ModificationAuthorMenu from './ModificationAuthorMenu';
    import ModificationVideos from '../video/ModificationVideos';
    import DisplayTotalRating from '../rating/DisplayTotalRating';
    import DisplayRatings from "../rating/DisplayRatings";

    export default {
        components: {
            DisplayRatings,
            ModificationFiles, ModificationGallery, ModificationAuthorMenu, ModificationVideos, DisplayTotalRating},
        mixins: [ routeMixin ],

        data() {
            return {
                mod: [],
                active: 'description'
            }
        },
        computed: {
            splashImageStyle() {
                return {
                    'background-image': `url("${this.mod.splash}")`,
                    'background-color': 'black',

                }
            },
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.mod.background}")`,
                }
            },
            fontTitle() {
                return {
                    'font-color': this.mod.font_color === null ? '#FFFFFF' : this.mod.font_color + ' !important',
                }
            },
        },
        methods: {
            assignData({mod}) {
                this.mod = mod;
                this.$emit('set-mod-link', this.mod.game_id, this.mod.category_id, this.mod.id);
            },
        },
    }
</script>
<style>
    .bg-semi-transparent{
        background-color: rgba(255,255,255, 0.5);
    }
</style>